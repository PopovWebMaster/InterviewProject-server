<?php 

namespace App\Http\Controllers\Auth\AuthTraits;

use Config;
use Validator;
use Auth;
use App\Dictionaries;
use App\User;
// use App\Projects;
use App\Settings;


// use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Auth\AuthTraits\EmailTrait;

trait LoginTrait {

    use AuthMethodsTrait;
    use EmailTrait;

    protected function get_a_json_message_to_login(){

        return [

            'section_id_name' => $this->data['section_id_name'], 

            'href_for_post' =>          route( 'login' ),
            'href_to_reset_password' => $this->get_href_to_reset_password(),
            'href_to_register' =>       route( 'register' ),

            'is_email_confirmed' => true, // при первой загрузке всегда должен быть true

            'inputMaxLength' => $this->getListInputMaxLength(),

            'action' => [
                'checkField' =>         CHECK_FIELD, 
                'tryToAccept' =>        TRY_TO_ACCEPT, 
                'confirmEmailAgain' =>  CONFIRM_EMAIL_AGAIN,
            ],

            EMAIL =>                    $this->get_a_shared_properties_object(),
            PASSWORD =>                 $this->get_a_shared_properties_object(),

        ];

    }

    private function get_href_to_reset_password(){
        $result = '';
        $settings = new Settings;
        $val = $settings->get_a_value_for_a_single_setting( 'is_password_reset_enabled' );
        if( $val ){
            $result = route( 'reset_password' );
        };
        return $result;
    }





    protected function connectsConstants_to_login(){

        $this->to_mount_the_shared_constants();

        // define( 'TRY_LOGIN',            Config::get('my_actions.authorization.tryLigin') ); // скорее всего не используется !!!!!!!!!!!
        define( 'CONFIRM_EMAIL_AGAIN',  Config::get('my_actions.authorization.confirmEmailAgain') );

        define( 'EMAIL_LOGIN',       'emailLogin' );
        define( 'PASSWORD_LOGIN',    'passwordLogin' );

    }


    protected function get_validation_list_rules(){

        return [
            EMAIL                 => 'required|email|max:255', 
            PASSWORD              => 'required',

        ];
    }


    private function get_rules_for_checking_a_one_field( $inputName ){
        $rules = [];
        $rulesList = $this->get_validation_list_rules();

        switch ( $inputName ) { 

            case EMAIL:
                $rules[ EMAIL_LOGIN ] =    $rulesList[ EMAIL ];
                break;

            case PASSWORD:
                $rules[ PASSWORD_LOGIN ] = $rulesList[ PASSWORD ];
                break;

        };

        return $rules;

    }

    private function get_check_arr_for_checking_a_one_field( $params ){ 

        $inputName =    $params[ 'inputName' ];
        $value =        $params[ 'value' ];

        $checkArray = [];

        if( $inputName === EMAIL ){
            $checkArray[ EMAIL_LOGIN ] = $value;

        }else if( $inputName === PASSWORD ){
            $checkArray[ PASSWORD_LOGIN ] = $value;
            
        };

        return $checkArray;

    }



    protected function check_one_field_login( $params ){ // $request

        $inputName =    $params[ 'inputName' ];
        $value =        $params[ 'value' ];

        $result = [
            'isError' =>        null,
            'errorMassage' =>   null,
        ];

        if( isset( $inputName ) ){

            if( isset( $value ) ){

                $rules =      $this->get_rules_for_checking_a_one_field( $inputName );
                $checkArray = $this->get_check_arr_for_checking_a_one_field( [ 'inputName' => $inputName, 'value' => $value] );

                $validator = Validator::make( $checkArray, $rules );

                if( $validator->fails() ){

                    $errArr = $validator->getMessageBag()->all();

                    $result[ 'isError' ] =      true;
                    $result[ 'errorMassage' ] = $errArr[0];

                }else{
                    $result[ 'isError' ] =      false;
                    $result[ 'errorMassage' ] = '';

                    if( $inputName === EMAIL && $value !== '' ){

                        $user = User::where( 'email', '=', $value )->first();

                        if( !isset( $user ) ){
                            $result[ 'isError' ] =      true;
                            $result[ 'errorMassage' ] = 'Пользователь с таким email не зарегистрирован';
                        };

                    };

                };

                

            }else{
                $result[ 'isError' ] =      true;
                $result[ 'errorMassage' ] = 'Что-то не так с полем $value';
            };

        }else{

            $result[ 'isError' ] =      true;
            $result[ 'errorMassage' ] = 'Что-то не так с полем $inputName';
            
        };

        return $result;

    }




    protected function check_all_input_field_data( $data ){ // $request->data

        $inputResponse = [];

        $listNames = [
            EMAIL,
            PASSWORD,
        ];

        $errors = [];

        for( $i = 0; $i < count( $listNames ); $i++ ){

            $data_InputName = null;
            $data_InputValue = '';

            if( isset( $data[ $listNames[$i] ] ) ){

                $data_InputName =    $listNames[$i];
                $data_InputValue =   $data[ $listNames[$i] ];

                $result_of_check = $this->check_one_field_login( 
                    [ 
                        'inputName' =>  $data_InputName, 
                        'value' =>      $data_InputValue 
                    ] 
                );

                $inputResponse[ $listNames[$i] ] = [
                    'value' =>          $data_InputValue,
                    'isError' =>        $result_of_check['isError'],
                    'errorMassage' =>   $result_of_check['errorMassage'],
                ];

                array_push( $errors, $result_of_check['isError'] );

            }else{

                $inputResponse[ $listNames[$i] ] = [
                    'value' =>          '',
                    'isError' =>        true,
                    'errorMassage' =>   'Ошибка, в запросе отсутсвует поле '.$listNames[$i],
                ];

                array_push( $errors, true );

            };

        };





        /*

            Здесь дописать правила проверки емейл


        */








        

        $ok = true;
        for( $i = 0; $i < count( $errors ); $i++ ){
            if( $errors[$i] === true ){
                $ok = false;
                break;
            };
        };

        return [
            'ok' => $ok,
            'inputResponse' => $inputResponse,
        ];



    }

    







}



?>