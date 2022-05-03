<?php 

namespace App\Http\Controllers\Auth\AuthTraits;

use Config;
use Validator;
use Auth;
use App\Dictionaries;
use App\User;
// use App\Projects;
// use App\Settings;


// use App\Http\Controllers\Auth\AuthController;

trait RegisterTrait {

    // use EmailTrait;
    use AuthMethodsTrait;

    protected function get_a_json_message_to_register(){

        return [
                
            'section_id_name' => $this->data['section_id_name'],

            'href_for_post' =>          route( 'register' ),
            'href_to_login' =>          route( 'login' ),

            'inputMaxLength' => $this->getListInputMaxLength(),

            'action' => [
                'checkField' =>     CHECK_FIELD,
                'tryToAccept' =>    TRY_TO_ACCEPT,
            ],

            NAME =>                     $this->get_a_shared_properties_object(),
            EMAIL =>                    $this->get_a_shared_properties_object(),
            PASSWORD =>                 $this->get_a_shared_properties_object(),
            PASSWORD_CONFIRMATION =>    $this->get_a_shared_properties_object(),

        ];

    }

    protected function connectsConstants_to_register(){

        $this->to_mount_the_shared_constants();

        define( 'USER_NAME',            'userName' );
        define( 'EMAIL_REGISTER',       'emailRegister' );
        define( 'PASSWORD_REGISTER',    'passwordRegister' );

  
    }

    protected function get_validation_list_rules(){

        $regex_user_name = Config::get('my_config.regex.user_name');

        return [
            NAME                  => 'required|max:255|regex:'.$regex_user_name,
            EMAIL                 => 'required|email|max:255|unique:users,email', // 
            PASSWORD              => 'required|min:6|max:255',
            PASSWORD_CONFIRMATION => 'required|min:6|max:255',

        ];
    }

    private function get_rules_for_checking_a_one_field( $inputName ){
        $rules = [];
        $rulesList = $this->get_validation_list_rules();

        switch ( $inputName ) { 

            case NAME:
                $rules[ USER_NAME ] =         $rulesList[ NAME ];
                break;

            case EMAIL:
                $rules[ EMAIL_REGISTER ] =    $rulesList[ EMAIL ];
                break;

            case PASSWORD:
                $rules[ PASSWORD_REGISTER ] = $rulesList[ PASSWORD ];
                break;

            case PASSWORD_CONFIRMATION:
                $rules[ PASSWORD_REGISTER ] = $rulesList[ PASSWORD_CONFIRMATION ];
                break;

        };

        return $rules;

    }

    private function get_check_arr_for_checking_a_one_field( $params ){ 

        $inputName =    $params[ 'inputName' ];
        $value =        $params[ 'value' ];

        $checkArray = [];

        if( $inputName === NAME ){
            $checkArray[ USER_NAME ] = $value;

        }else if( $inputName === EMAIL ){
            $checkArray[ EMAIL_REGISTER ] = $value;

        }else if( $inputName === PASSWORD ){
            $checkArray[ PASSWORD_REGISTER ] = $value;
            
        }else if( $inputName === PASSWORD_CONFIRMATION ){
            $checkArray[ PASSWORD_REGISTER ] = $value;
        };

        return $checkArray;

    }

    protected function check_one_field_register( $params ){ // $request

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
            NAME, 
            EMAIL,
            PASSWORD,
            PASSWORD_CONFIRMATION
        ];

        $errors = [];

        for( $i = 0; $i < count( $listNames ); $i++ ){

            $data_InputName = null;
            $data_InputValue = '';

            if( isset( $data[ $listNames[$i] ] ) ){

                $data_InputName =    $listNames[$i];
                $data_InputValue =   $data[ $listNames[$i] ];

                $result_of_check = $this->check_one_field_register( 
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

        if( $data[ PASSWORD ] !== $data[ PASSWORD_CONFIRMATION ] ){
            $inputResponse[ PASSWORD_CONFIRMATION ] = [
                'value' =>          '',
                'isError' =>        true,
                'errorMassage' =>   'Была допущена ошибка при повторном вводе пароля',
            ];
            array_push( $errors, true );
        };

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


    protected function add_new_user_into_database( $userInfo ){

        $res = User::create([
            NAME =>           $userInfo[ NAME ],
            EMAIL =>          $userInfo[ EMAIL ],
            // PASSWORD =>       bcrypt( $userInfo[ PASSWORD ] ),
            PASSWORD =>       $this->get_a_hashed_password( $userInfo[ PASSWORD ] ),

            'sectet_token_confirmed' => $this->get_token(),
        ]);

        return [
            'ok' => $res,
        ];

    }

    


    protected function get_token() {
        $token = sprintf(
            // '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            '%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
     
        return $token;
    }











    


};

