<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage; // !!!!!

use App\Helpers\ModelHelpers\Dictionaries\ListDictionaries\UserResult;

use Validator;
use Config;
use Auth;

use App\Dictionaries;
use App\Projects;
use App\Settings;

use App\Helpers\ModelHelpers\Dictionaries\ListDictionaries\GetListDictionariesFromClient;
use App\Helpers\SharedHelpers\GetMinSumWordsInOneLevel;

class TrainingController extends SiteController
{
    public function __construct(){
        parent::__construct();
        //$this->middleware('auth');

    }

    public function get( $queue = null ){

        $rules['queue'] = 'required|integer|digits_between:1,6|min:1';
        $checkArray = [
            'queue' => $queue,
        ];
        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            return redirect()->route('dictionaries');
        };

        $dictionary = Dictionaries::where('queue', '=', $queue )->first();

        if( is_null( $dictionary ) ){
            return redirect()->route('dictionaries');
        };

        if( !$this->checksUserAccessToDictionary( $queue ) ){
            // проверяет, есть ли у пользователя право доступа к данному словарю с очередью $queue
            return redirect()->route('dictionaries');
        };

        $projects = new Projects();
        $words = $projects->getListWordsFromDictionary( $dictionary->projects_id );

        $settings  = new Settings();
        $setting = $settings->where('name', '=', 'scale_stars_for_one_dictionary')->first();
        $scale_stars_for_one_dictionary = (int)$setting->value;

        $section_id_name = 'training';
        $this->data['section_id_name'] = $section_id_name;

        $min_sum_words = GetMinSumWordsInOneLevel::make( count( $words ) );
        
        $this->setJson([
            'section_id_name' => $section_id_name,
            'num_dictionary' => $dictionary->id,
            'href_for_post' => route( 'training', [ 'queue' => $queue ] ),
            'user_result' => $this->getUserResult( $dictionary->id ),
            'user_vocabulary' => $this->getVocabulary(),
            'sum_words' => count( $words ),
            'min_sum_words' => $min_sum_words,
            'scale_stars_for_one_dictionary' => $scale_stars_for_one_dictionary,
            'queue' => $queue,
            'tasks' => [
                'etap_1' => Config::get('my_tasks.etap_1'),
                'etap_2' => Config::get('my_tasks.etap_2'),
                'etap_3' => Config::get('my_tasks.etap_3'),
                'etap_4' => Config::get('my_tasks.etap_4'),
                'etap_5' => Config::get('my_tasks.etap_5'),
            ],
            'href_for_audio_file' => asset( '/storage/audio/'.$dictionary->projects_id ),
            'sum_of_pats_of_words' => 5,
            'words' => $words,
            'cycle_length_in_the_training' => 10,
            'actions' => [
                'setResult' => Config::get('my_actions.training.setUserResult'),
            ],

        ]);

        if( view()->exists('default.training') ){
            return view( 'default.training', $this->data );
        };
        abort(404);

    }

    public function post( Request $request, $queue ){

        $this->connectsConstants();

        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request, $queue  );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            return [
                'ok' =>                 false,
                'errors' =>             $validator->getMessageBag()->all(),
                'user_result' =>        $this->getUserResult( $dictionary->id ),
                'user_vocabulary' =>    $this->getVocabulary(),
            ];
        };
        

        if( $request->action === SET_NEW_RESULT ){
            
            $responce_from_set = $this->setUserResult([
                'queue' =>      $queue,
                'userResult' => $checkArray['user_result_in_this_dictionary'],
            ]);

            $dictionary = Dictionaries::where( 'queue', '=', $queue )->first();

            return [
                'ok' =>                 $responce_from_set['ok'],
                'errors' =>             $responce_from_set['errors'],
                'user_result' =>        $this->getUserResult( $dictionary->id ),
                'user_vocabulary' =>    $this->getVocabulary(),
            ];

        };

    }

    private function connectsConstants(){

        define( 'SET_NEW_RESULT',  Config::get('my_actions.training.setUserResult') );
        
    }

    private function getRulesValidation( $request ){

        $rules = [];

        $rules['action'] =  'required|string|alpha_num|in:'.SET_NEW_RESULT;
        $rules['queue'] =   'required|integer|digits_between:1,6|min:1';

        if( $request->action === SET_NEW_RESULT ){
            $rules['user_result_in_this_dictionary'] = 'required|integer|digits_between:1,6|min:0';
        };

        return $rules;

    }

    private function getCheckArray( $request, $queue ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, что бы сделать из того что прийдёт в $request, массив с уникальными полями, 
        // а данные уникальные поля уже потом можно было использовать в validation.php для создания корректных, уникальных
        // сообщений об ошибках валидации

        $checkArray = [];

        $dictionary = Dictionaries::where('queue', '=', $queue )->first();
        if( is_null( $dictionary ) ){
            $checkArray['queue'] = '';
        }else{
            $checkArray['queue'] = (int)$queue;
        };
        
        if( isset( $request->action ) ){
            $checkArray['action'] = $request->action;
        };

        if( isset( $request->data['user_result_in_this_dictionary'] ) ){
            $checkArray['user_result_in_this_dictionary'] = (int)$request->data['user_result_in_this_dictionary'];

        };

        return $checkArray;

    }

    private function getUserResult( $dictionary_id ){
        $usRes = new UserResult();
        $userResult = $usRes->get();

        $result;
        if( isset( $userResult[$dictionary_id] ) ){
            $result = $userResult[$dictionary_id];
        }else{
            $result = 0;
        };

        return $result;

    }

    public function setUserResult( $params = null ){
        $ok = false;
        $errors = [];

        $auth = Auth::user();

        if( isset( $auth ) ){
            if( isset( $params ) ){
                $queue =        (int)$params['queue'];
                $userResult =   (int)$params['userResult'];

                $user_id = $auth->id;

                $dictionary = Dictionaries::where( 'queue', '=', $queue )->first();

                if( !is_null( $dictionary ) ){

                    $UserResult_ex = new UserResult();

                    $responce_from_set = $UserResult_ex->set([
                        'user_id' =>        $user_id,
                        'dictionary_id' =>  $dictionary->id,
                        'new_result' =>     $userResult,
                    ]);

                    if( $responce_from_set['ok'] ){
                        $ok = true;
                    }else{
                        $ok = false;
                        array_push( $errors, $responce_from_set['errors'] );
                    };   
                }else{
                    array_push( $errors, "Ошибка, не существует словаря с под таким псевдонимом {$queue}" );
                };
            }else{
                array_push( $errors, 'Ошибка в использования метода setUserResult(), не передан $params');
            };
        }else{
            array_push( $errors, 'Ошибка, незарегистрированные пользователи не могут делать запись о результате');
        };

        return [
            'ok' => $ok,
            'errors' => $errors
        ];

    }

    private function getVocabulary(){
        $usRes = new UserResult();
        $userResult = $usRes->get();
        $voc = 0;

        if( !is_null( $userResult ) ){
            foreach( $userResult as $k => $v ){
                $voc = $voc + $v;
            };
        };

        return $voc;

    }

    private function checksUserAccessToDictionary( $queue ){
        $listDictionaries = GetListDictionariesFromClient::make();

        $isAccess = false;

        foreach( $listDictionaries as $level=>$data){
            if( isset($data[$queue]) ){
                $isAccess = true;
                break;
            };
        };

        return $isAccess;
       
    }




}
