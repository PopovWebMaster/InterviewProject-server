<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Projects;

use AudioFiles;
use Config;
use Validator;

class ProjectController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();

        $this->connectsConstants();

    }

    public function get( $id ){



        $PROJECT = new Projects;
        $project = $PROJECT->find( $id );

        if( $project === null ){
            return redirect()->route('admin_projects');
        };

        $this->setJson([
            'currentPage'=>'PROJECT',
            'name' => $project->name,
            'description' => $project->description,
            'words' => $PROJECT->getListWordsFromClient( $id ), // $responseArr
            'audioList' => AudioFiles::getList( $id ),
            'created_at' => $project->created_at,
            'status' => $project->status,
            'author' => $project->author,
            'href_for_post' => route( 'admin_project', [ 'id' => $id ] ),
            'href_for_audio_files' => route( 'admin_audio', [ 'id' => $id ] ),
            'href_for_audio_file' => asset( '/storage/audio/'.$id ),
            'instruction' => Config::get('my_instructions.rules'),
            'action' => [
                'setDescription' => SET_DESCRIPTION,
                'deleteOneWord' => DELETE_ONE_WORD,
                'updateWords' => UPDATE_WORDS,
                'setNewWords' => SET_NEW_WORDS,
                'getWords' => GET_WORDS,
            ],

			//'href_for_audio_file' => asset( '/' )
        ]);


        
        // dd( json_decode( $project->words, true ) );













        $this->data['name'] = $project->name;

        if( view()->exists('admin.projectAdmin') ){
            return view( 'admin.projectAdmin', $this->data );
        };
        abort(404);

    }

    public function post( Request $request,  $id ){

        
        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request, $id );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            return [
                'ok' => false, 
                'massage' => $validator->getMessageBag()->all()
            ];
        };

        $PROJECT = new Projects;
        $project = $PROJECT->find( (int)$id );

        if( is_null( $project ) ){
            return [
                'ok' => false, 
                'massage' => 'Нет такого id в БД',
            ];
        };

        $errors = '';

        if( $request->action === SET_DESCRIPTION ){
            // $request->data['description'] должен содаржать строку, 
            // в том числе может содержать и пустую строку ('')

            $project->description = $request->data['description'] ;
            $project->save();
            return [
                'ok' => true,
                'description' => $request->data['description'] 
            ];

        }else if( $request->action === SET_NEW_WORDS ){
            // Пример $request->words:
            //     [
            //         [
            //             'enW' => 'word',
            //             'ruW' => 'слово'
            //         ],
            //         ...
            //     ]

            if( count($request->words ) > 0 ){

                $res = $PROJECT->setNewWords( $id, $request->words );

                return [
                    'ok' => true,
                    'words' => $res, 
                    'audioList' => AudioFiles::getList( $id ),
                ];
            }else{
                $errors = 'Действие отменено, в words был передан пустой массив';
            };

        }else if( $request->action === UPDATE_WORDS ){
            // Пример $request->words:
            //     [
            //         [
            //             'enW' => 'word',
            //             'ruW' => 'слово'
            //         ],
            //         ...
            //     ]

            if( count($request->words ) > 0 ){

                $res = $PROJECT->updateWords( $id, $request->words );

                return [
                    'ok' => true,
                    'words' => $res, 
                    'audioList' => AudioFiles::getList( $id ),
                ];
            }else{
                $errors = 'Действие отменено, в words был передан пустой массив';
            };

        }else if( $request->action === DELETE_ONE_WORD ){
            // Пример $request->deletedArr:
            //     [
            //         [
            //             'enW' => 'word',
            //             'ruW' => 'слово'
            //         ]
            //     ]
            // Длина массива должна быть равна 1 

            if( count( $request->deletedArr ) === 1 ){
                    
                $res = $PROJECT->deleteWords( $id, $request->deletedArr );

                return [
                    'ok' => true,
                    'words' => $res, 
                    'audioList' => AudioFiles::getList( $id ),
                ];
            }else{
                $errors = 'Действие отменено, deletedArr имеет длину отличную от 1';
            };

        }else if( $request->action === GET_WORDS ){

            $words = $PROJECT->getListWordsFromClient( $id );

            return [
                'ok' => true,
                'words' => $words,
            ];
        };
 
  
        return [
            'ok' => false, 
            'errors' => $errors
        ];

    }


    private function getCheckArray( $request, $id ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, что бы сделать из того что прийдёт в $request, массив с уникальными полями, 
        // а данные уникальные поля уже потом можно было использовать в validation.php для создания корректных, уникальных
        // сообщений об ошибках валидации

        $checkArray = [];
        $checkArray['id'] = (int)$id;
        
        if( isset( $request->action ) ){
            $checkArray['action'] = $request->action;
        };

        if( isset( $request->data['description'] ) ){
            $checkArray[ NEW_DESCRIPTION ] = $request->data['description'];
        };

        if( isset( $request->words ) ){

            // Ограничитель длинны массива
            $max_length = 1001;
            $arr = [];
            for( $i = 0; $i < $max_length; $i++ ){
                if( isset( $request->words[ $i ] ) ){
                    array_push( $arr, $request->words[ $i ] );
                }else{
                    break;
                };
            };
            $checkArray[ WORDS ] = $arr;

        };

        if( isset( $request->deletedArr ) ){

            // Ограничитель длинны массива
            $max_length = 1001;
            $arr = [];
            for( $i = 0; $i < $max_length; $i++ ){
                if( isset( $request->deletedArr[ $i ] ) ){
                    array_push( $arr, $request->deletedArr[ $i ] );
                }else{
                    break;
                };
            };
            $checkArray[ DELETE_ARR ] = $arr;

        };

        return $checkArray;

    }

    private function getRulesValidation( $request ){

        $regex_newDescription = Config::get('my_config.regex.newDescription');
        $regex_enW =            Config::get('my_config.regex.enW');
        $regex_ruW =            Config::get('my_config.regex.ruW');

        $rules = [];
        $rules['action'] =   'required|string|alpha_num|in:'.SET_DESCRIPTION.','.DELETE_ONE_WORD.','.UPDATE_WORDS.','.SET_NEW_WORDS.','.GET_WORDS;
        $rules['id'] =       'required|integer|digits_between:1,6|min:1';

        if( $request->action === SET_DESCRIPTION ){

            if( $request->data['description'] === '' ){
                $rules[ NEW_DESCRIPTION ] = 'string|regex:'.$regex_newDescription;
            }else{
                $rules[ NEW_DESCRIPTION ] = 'required|string|regex:'.$regex_newDescription;
            };

        }else if( $request->action === DELETE_ONE_WORD ){

            $rules[ DELETE_ARR ] =          'required|array';
            $rules[ DELETE_ARR.'.*.enW' ] = 'required_with:'.DELETE_ARR.'.*.ruW|regex:'.$regex_enW;
            $rules[ DELETE_ARR.'.*.ruW' ] = 'required_with:'.DELETE_ARR.'.*.enW|regex:'.$regex_ruW;
 

        }else if( $request->action === UPDATE_WORDS ){

            $rules[ WORDS ] =           'required|array';
            $rules[ WORDS.'.*.enW' ] =  'required_with:'.WORDS.'.*.ruW|regex:'.$regex_enW;
            $rules[ WORDS.'.*.ruW' ] =  'required_with:'.WORDS.'.*.enW|regex:'.$regex_ruW;

        }else if( $request->action === SET_NEW_WORDS ){

            $rules[ WORDS ] =           'required|array';
            $rules[ WORDS.'.*.enW' ] =  'required_with:'.WORDS.'.*.ruW|regex:'.$regex_enW;
            $rules[ WORDS.'.*.ruW' ] =  'required_with:'.WORDS.'.*.enW|regex:'.$regex_ruW;

        }/*else if( $request->action === GET_WORDS ){
            
            
        }*/;

        return $rules;
        
    }

    private function connectsConstants(){

        define( 'SET_DESCRIPTION',  'setDescription' );
        define( 'DELETE_ONE_WORD',  'deleteOneWord'  );
        define( 'UPDATE_WORDS',     'updateWords'    );
        define( 'SET_NEW_WORDS',    'setNewWords'    );
        define( 'GET_WORDS',        'getWords'    );


        define( 'NEW_DESCRIPTION',  Config::get('my_config.request_nickname.project.newDescription')    );
        define( 'WORDS',            Config::get('my_config.request_nickname.project.words')             );
        define( 'DELETE_ARR',       Config::get('my_config.request_nickname.project.deletedArr')        );

    }




















}
