<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Settings;

use Validator;
use Config;

    /*
        ИНСТРУКЦИЯ ПО СОЗДАНИЮ НОВЫХ НАСТРОЕК

        1 - в БД таблицу settings сделать запись (вручную) новой настройки, где:

            description - описание свойства, это текст который будет отображон на странице в качестве названия поля настройки
            name - имя, которое предназначенное для использования в качестве имён полей объектов (js, php)
            value - значение, (всегда строка)
            default_value - значение для установки во время сброса настроек (всегда строка)
            interval - (названо некорректно) это json-объект или массив в котором содержатсья дополнительные параметры. 

                Варианты заполнения interval
            - пустая строка ""                      (input type text)
            - объект ['from' => 1, 'to' => 100]     (select option)
            - массив значений:
                    ['one', 'two, 'six', ...]       (input type checkbox)
                    ['true', 'false ]               (input type radio)

        ------------------------------------------------------------------------------------------------------------------------

        2 - Добавить правило в getRulesValidation() (по указанному в нём же примеру)

        ------------------------------------------------------------------------------------------------------------------------

        3 - Добавить новый элемент к проверочному массиву в getCheckArray() (по указанному в нём же примеру) 

        ------------------------------------------------------------------------------------------------------------------------

        4 - В модели Settings в поле $how_to_display_settings_properties (порядок отображения свойств) добавить в список 
            name-имя нового свойства. 

    */



class SettingController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();

    }
    
    public function get(){

        $settings = new Settings;

        $this->setJson([
            'currentPage' => 'SETTING',
            'arrListSettings' => $settings->getListSettingsForClient(),
            'href_for_post' => route( 'admin_setting' ),
            'actions' => [
                'setNewSettings' => 'setNewSettings',
            ],
        ]);

        if( view()->exists('admin.settingAdmin') ){
            return view( 'admin.settingAdmin', $this->data );
        };
        abort(404);

    }

    public function post( Request $request ){

        // Пример $request->params = [
        //     'site_name_part_1'=> "От ноля до 10 000",
        //     'site_name_part_2'=> "english words",
        //     'sum_dictionaries_in_one_level'=> "4",
        //     'scale_stars_for_one_dictionary'=> "6",
        //     'passing_score_from_100'=> "95",
        //     ...
        // ]


        $this->connectsConstants();
        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request );

        $validator = Validator::make( $checkArray , $rules );
        if( $validator->fails() ){
            return [
                'href' => route('admin_setting'),
                'ok' => false, 
                'massage' => $validator->getMessageBag()->all(),
                'params' => $request->params
            ];
        };

        $ok = false;

        if( $request->action === SET_NEW_SETTINGS ){

            $setting = new Settings;
            $setting->setNewSettings( $request->params );

            $ok = true;

        };/*else if( $request->action === SET_DEFAULT_SETTINGS ){

            $setting = new Settings;
            $setting->setDefaultSettings();

            $ok = true;
        }*/

        return [
            'ok' => $ok,
            'href' => route('admin_setting')
        ];

    }

    private function getCheckArray( $request ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, что бы сделать из того что прийдёт в $request, массив с уникальными полями, 
        // а данные уникальные поля уже потом можно было использовать в validation.php для создания корректных, уникальных
        // сообщений об ошибках валидации


        $checkArray = [];
        $checkArray['action'] = isset( $request->action )? $request->action: '';

        $checkArray[ PARAMS_STR ] = [
            'site_name_part_1' =>   isset( $request->params['site_name_part_1'] )? $request->params['site_name_part_1']: '',
            'site_name_part_2' =>   isset( $request->params['site_name_part_2'] )? $request->params['site_name_part_2']: '',
            'keywords' =>           isset( $request->params['keywords'] )? $request->params['keywords']: '',
            'description' =>        isset( $request->params['description'] )? $request->params['description']: '',

        ];

        $checkArray[ PARAMS_NUM ] = [
            'sum_dictionaries_in_one_level' =>      isset( $request->params['sum_dictionaries_in_one_level'] )? $request->params['sum_dictionaries_in_one_level']: '',
            'scale_stars_for_one_dictionary' =>     isset( $request->params['scale_stars_for_one_dictionary'] )? $request->params['scale_stars_for_one_dictionary']: '',
            'passing_score_from_100' =>             isset( $request->params['passing_score_from_100'] )? $request->params['passing_score_from_100']: '',

        ];

        $checkArray[ PARAMS_RADIO ] = [
            'sending_a_message_during_registration' =>  isset( $request->params['sending_a_message_during_registration'] )? $request->params['sending_a_message_during_registration']: '',
            'is_password_reset_enabled' =>              isset( $request->params['is_password_reset_enabled'] )? $request->params['is_password_reset_enabled']: '',
            'site_is_closed' =>                         isset( $request->params['site_is_closed'] )? $request->params['site_is_closed']: '',
            
        ];

        $checkArray[ PARAMS_CHECKBOX ] = [

        ];

        return $checkArray;

    }




    private function getRulesValidation( $request ){

        $regex_settings_str = Config::get('my_config.regex.settings_str');

        // $rules_str = 'required|string|regex:'.$regex_settings_str;
        // $reles_num = 'required|integer|digits_between:1,6';

        $rules_from_text =      'required|string|regex:'.$regex_settings_str;
        $rules_from_number =    'required|integer|digits_between:1,6';
        $rules_from_checkbox =  'required|string|regex:'.$regex_settings_str; // < - здесь уязвимость!!!!!!!!!!!!
        $rules_from_radio =     'required|string|alpha_num|in:true,false';

        $rules = [];
        $rules['action'] = 'required|string|alpha_num|in:'.SET_NEW_SETTINGS.','.SET_DEFAULT_SETTINGS;

        if( $request->action === SET_NEW_SETTINGS ){

            $rules[ PARAMS_STR ] = 'array';
            $rules[ PARAMS_NUM ] = 'array';
            $rules[ PARAMS_RADIO ] = 'array';
            $rules[ PARAMS_CHECKBOX ] = 'array';

            $rules[ PARAMS_STR.'.site_name_part_1' ] =                      $rules_from_text;
            $rules[ PARAMS_STR.'.site_name_part_2' ] =                      $rules_from_text;
            $rules[ PARAMS_STR.'.keywords' ] =                              $rules_from_text;
            $rules[ PARAMS_STR.'.description' ] =                           $rules_from_text;

            $rules[ PARAMS_NUM.'.sum_dictionaries_in_one_level' ] =         $rules_from_number;
            $rules[ PARAMS_NUM.'.scale_stars_for_one_dictionary' ] =        $rules_from_number;
            $rules[ PARAMS_NUM.'.passing_score_from_100' ] =                $rules_from_number;

            $rules[ PARAMS_RADIO.'.sending_a_message_during_registration' ] = $rules_from_radio;
            $rules[ PARAMS_RADIO.'.is_password_reset_enabled' ] =             $rules_from_radio;
            $rules[ PARAMS_RADIO.'.site_is_closed' ] =                        $rules_from_radio;
            

            /*
                Новое правило добавлять сюда

                $rules[ PARAMS_STR.'.название_правила' ] = $rules_str;
                или
                $rules[ PARAMS_NUM.'.название_правила' ] = $reles_num;
            */

   
        }/*else if( $request->action === SET_DEFAULT_SETTINGS ){
            Правила для SET_DEFAULT_SETTINGS отсутствуют
        }*/;

        return $rules;
        
    }


    private function connectsConstants(){

        define( 'SET_DEFAULT_SETTINGS', 'setDefaultSettings' );
        define( 'SET_NEW_SETTINGS',     'setNewSettings'  );
       
        define( 'PARAMS_NUM',       Config::get('my_config.request_nickname.settings.paramsNum') );
        define( 'PARAMS_STR',       Config::get('my_config.request_nickname.settings.paramsStr') );
        define( 'PARAMS_RADIO',     Config::get('my_config.request_nickname.settings.paramsRadio') );
        define( 'PARAMS_CHECKBOX',  Config::get('my_config.request_nickname.settings.paramsCheckbox') );



       
    }



};






































		