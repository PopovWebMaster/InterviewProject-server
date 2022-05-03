<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use IsRepeat;

use App\Dictionaries;
use App\Projects;

use Validator;
use Config;

class AnalysisController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();
 
    }

    public function get(){

        // Получает список всех проектов
		$arrListAllProjects = [];
		$proj = new Projects;
        $proj = $proj->get();
        foreach( $proj as $obj ){
			$resObj = [
                'id'=> $obj->id,
                'name' => $obj->name
            ];
            array_push( $arrListAllProjects, $resObj );
        };

        $this->setJson([
            'currentPage' => 'ANALYSIS',
            'arrListFreeProjects' => $arrListAllProjects,
			'href_for_post' => route( 'admin_analysis' ),
        ]);

        if( view()->exists('admin.analysisAdmin') ){
            return view( 'admin.analysisAdmin', $this->data );
        };
        abort(404);

    }

    public function post( Request $request ){
        // Пример $request->wordsForCheck = [
        //     'words',
        //     'analysis',
        //     'five',
        //     ...
        // ]

        $this->connectsConstants();
        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            return [
                'ok' => false,
                //'errors' => $validator->getMessageBag()->all()
            ];
        };

        if( $request->action === CHECK_WORDS ){
       
            $words = $request->wordsForCheck;
            $arr_result = [];
            foreach( $words as $enW ){

                $res = IsRepeat::check( $enW );
                $result = [
                    'checked_enW' => $enW,
                    'exists' => $res['exists'],
                    'project' => $res['project'],
                    'ruW' => isset( $res['ruW'] )? $res['ruW']: ''
                ];
               
                array_push( $arr_result, $result );
            }; 

            $arr = [
                'ok' => true,
                'result' => $arr_result
            ];

            return $arr;

        }else if( $request->action === SEND_TO_PROJECT ){
			/*
				Принимает :
				words = [
                    [ 'enW' => 'word', 'ruW' => 'слово'],
                    ...
				]
				idProject = 1
            */
			
			$id = $request->idProject;
			$arr = $request->words;
            $project = new Projects;

            $check_id = $project->find( $id );
            if( !is_null( $check_id ) ){
                $res = $project->setNewWords( $id, $arr );
                $ok;
                if( is_string( $res ) ){ // Ошибка, не записалось
                    $ok = false;
                }else{
                    $ok = true;
                };

                return [
                    'ok' => $ok
                ];
            };
        };

        return [
            'ok' => false,
            //'errors' => 'Неизвестная ошибка'
        ];

    }

    private function getCheckArray( $request ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, что бы сделать из того что прийдёт в $request, массив с уникальными полями, 
        // а данные уникальные поля уже потом можно было использовать в validation.php для создания корректных, уникальных
        // сообщений об ошибках валидации

        $checkArray = [];
        
        if( isset( $request->action ) ){
            $checkArray['action'] = $request->action;
        };

        if( isset( $request->wordsForCheck ) ){
            $max_length = 1001;
            // Ограничитель длинны массива
            $arr = [];
            for( $i = 0; $i < $max_length; $i++ ){
                if( isset( $request->wordsForCheck[ $i ] ) ){
                    array_push( $arr, $request->wordsForCheck[ $i ] );
                }else{
                    break;
                };
            };
            $checkArray[ WORDS_FOR_CHECK ] = $arr;
            
        };

        if( isset( $request->idProject ) ){
            $checkArray[ ID_PROJECT ] = $request->idProject;
        };

        if( isset( $request->words ) ){
            $checkArray[ WORDS ] = $request->words;
        };

        return $checkArray;

    }

    private function getRulesValidation( $request ){

        $regex_enW = Config::get('my_config.regex.enW');
        $regex_ruW = Config::get('my_config.regex.ruW');

        $rules = [];
        $rules['action'] = 'required|string|alpha_num|in:'.CHECK_WORDS.','.SEND_TO_PROJECT;

        if( $request->action === CHECK_WORDS ){

            $rules[ WORDS_FOR_CHECK ] =      'required|array';
            $rules[ WORDS_FOR_CHECK.'.*' ] = 'string|regex:'.$regex_enW;
    
        }else if( $request->action === SEND_TO_PROJECT ){

            $rules[ ID_PROJECT ] =      'required|integer|digits_between:1,6|min:1';
            $rules[ WORDS ] =           'required|array';
            $rules[ WORDS.'.*.enW' ] =  'required_with:'.WORDS.'.*.ruW|regex:'.$regex_enW;
            $rules[ WORDS.'.*.ruW' ] =  'required_with:'.WORDS.'.*.enW|regex:'.$regex_ruW;

        };

        return $rules;
    }

    private function connectsConstants(){

        define( 'CHECK_WORDS',          'checkWords' );
        define( 'SEND_TO_PROJECT',      'sendToProject' );

        define( 'WORDS_FOR_CHECK',      Config::get('my_config.request_nickname.analysis.wordsForCheck') );
        define( 'ID_PROJECT',           Config::get('my_config.request_nickname.analysis.idProject') );
        define( 'WORDS',                Config::get('my_config.request_nickname.analysis.words') );

    }



















}
