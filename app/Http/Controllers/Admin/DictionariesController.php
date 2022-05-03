<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Dictionaries;
use App\Projects;
use App\Settings;

use Config;
use Validator;

class DictionariesController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();
		
        $dic = new Dictionaries;
        $settings = new Settings();

        $sett = $settings->where( 'name', '=','sum_dictionaries_in_one_level' )->first();
        $sum_dictionaries_in_one_level = (int)$sett->value;
        
        $this->setJson([
            'currentPage'=>'DICTIONARIES',
            'listDictionaries' => $dic->getListDictionaries(),
			'href_for_post' => route( 'admin_dictionaries'),
			'sum_dictionaries_in_one_level' => $sum_dictionaries_in_one_level // временно 4 длжна быть взята от кудато
        ]);
    }
    
    public function get(){

        if( view()->exists('admin.dictionariesAdmin') ){
            return view( 'admin.dictionariesAdmin', $this->data );
        };
        abort(404);

    }

    public function post( Request $request ){

        $this->connectsConstants();
        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            return [
                'ok' => false,
                'massage' => $validator->getMessageBag()->all()
            ];
        };

        if( $request->action === CREATE_DICTIONARY ){

            $dic = new Dictionaries;
            $dic->createDictionary( $request->name );
            $listDictionaries = $dic->getListDictionaries();

            return [
                'ok' => true, 
                'listDictionaries' => $listDictionaries,
            ];

        };

        return [
            'ok' => false, 
            'listDictionaries' => $listDictionaries, //'massage' => $validator->getMessageBag()->all()
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

        if( isset( $request->name ) ){
            $checkArray[ NEW_NAME ] = $request->name;
        };

        return $checkArray;

    }

    private function getRulesValidation( $request ){

        $regex_dictionaryName = Config::get('my_config.regex.dictionaryName');

        $rules = [];
        $rules['action'] = 'required|string|alpha_num|in:'.CREATE_DICTIONARY;

        if( $request->action === CREATE_DICTIONARY ){
            $rules[ NEW_NAME ] = 'required|string|unique:dictionaries,name|regex:'.$regex_dictionaryName;
        };

        return $rules;

    }

    private function connectsConstants(){
        define( 'CREATE_DICTIONARY', 'createDictionary' );
        define( 'NEW_NAME', Config::get('my_config.request_nickname.dictionaries.name') );
    }









































}
