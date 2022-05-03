<?php 

namespace App\Http\Controllers\Auth\AuthTraits;

use Config;
use Validator;
use Auth;
use App\Dictionaries;
use App\User;
// use App\Projects;
// use App\Settings;
// use App\ResetPassword;



// use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Auth\AuthTraits\TestsTraits\TestResetPasswordTrait;

trait PasswordResetTrait {

    // use EmailTrait;
    use AuthMethodsTrait;
    use TestResetPasswordTrait;

    protected function get_a_json_message_to_reset_password(){

        return [
                
            'section_id_name' => $this->data['section_id_name'],

            'href_for_post' =>          route( 'reset_password' ),

            'inputMaxLength' => $this->getListInputMaxLength(),

            'action' => [
                'checkField' =>     CHECK_FIELD,
                'tryToAccept' =>    TRY_TO_ACCEPT,
            ],

            EMAIL =>                    $this->get_a_shared_properties_object(),
            SECRET_CODE =>              $this->get_a_shared_properties_object(),
            PASSWORD =>                 $this->get_a_shared_properties_object(),
            PASSWORD_CONFIRMATION =>    $this->get_a_shared_properties_object(),

        ];

    }

    protected function connectsConstants_to_reset_password(){

        $this->to_mount_the_shared_constants();

        define( 'SECRET_CODE_RESET_PASSWORD', 'secretCode' );
        define( 'EMAIL_RESET_PASSWORD',       'emailResetPassword' );
        define( 'PASSWORD_RESET_PASSWORD',    'passwordResetPassword' );

  
    }


    protected function get_validation_list_rules(){

        return [
            EMAIL                 => 'required|email|max:255', 
            SECRET_CODE           => 'required|alpha_num|size:12',
            PASSWORD              => 'required|min:6|max:255',
            PASSWORD_CONFIRMATION => 'required|min:6|max:255',

        ];

    }




    private function get_rules_for_checking_a_one_field( $inputName ){
        $rules = [];
        $rulesList = $this->get_validation_list_rules();

        switch ( $inputName ) { 

            case EMAIL:
                $rules[ EMAIL_RESET_PASSWORD ] =        $rulesList[ EMAIL ];
                break;

            case SECRET_CODE:
                $rules[ SECRET_CODE_RESET_PASSWORD ] =  $rulesList[ SECRET_CODE ];
                break;

            case PASSWORD:
                $rules[ PASSWORD_RESET_PASSWORD ] =     $rulesList[ PASSWORD ];
                break;

            case PASSWORD_CONFIRMATION:
                $rules[ PASSWORD_RESET_PASSWORD ] =     $rulesList[ PASSWORD_CONFIRMATION ];
                break;

        };

        return $rules;

    }

    private function get_check_arr_for_checking_a_one_field( $params ){ 

        $inputName =    $params[ 'inputName' ];
        $value =        $params[ 'value' ];

        $checkArray = [];

        if( $inputName === EMAIL ){
            $checkArray[ EMAIL_RESET_PASSWORD ] = $value;

        }else if( $inputName === SECRET_CODE ){
            $checkArray[ SECRET_CODE_RESET_PASSWORD ] = $value;

        }else if( $inputName === PASSWORD ){
            $checkArray[ PASSWORD_RESET_PASSWORD ] = $value;
            
        }else if( $inputName === PASSWORD_CONFIRMATION ){
            $checkArray[ PASSWORD_RESET_PASSWORD ] = $value;
        };

        return $checkArray;

    }

    protected function check_one_field_reset_password( $params ){ 

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

                    if( $inputName === EMAIL && $value !== '' ){

                        $user = User::where( 'email', '=', $value )->first();

                        if( !isset( $user ) ){
                            $result[ 'isError' ] =      true;
                            $result[ 'errorMassage' ] = 'Пользователь с таким email не зарегистрирован';

                        }else{
                            $result[ 'isError' ] =      false;
                            $result[ 'errorMassage' ] = '';

                        };

                    }else{
                        $result[ 'isError' ] =      false;
                        $result[ 'errorMassage' ] = '';
                        
                    };


                };

            }else{
                $result[ 'isError' ] =      true;
                $result[ 'errorMassage' ] = 'Значение поля или отсутствует, или равно null';
            };

        }else{

            $result[ 'isError' ] =      true;
            $result[ 'errorMassage' ] = 'Имя поля или отсутствует, или равно null';
            
        };

        return $result;

    }


    protected function check_all_input_field_data( $data ){ // $request->data

        $inputResponse = [];

        $listNames = [
            EMAIL,
            SECRET_CODE, 
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

                if( $data_InputValue !== '' ){
                    $result_of_check = $this->check_one_field_reset_password( 
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
                        'value' =>          $data_InputValue,
                        'isError' =>        false,
                        'errorMassage' =>   '',
                    ];
                    array_push( $errors, false );
                };

                

            };
            /*else{

                $inputResponse[ $listNames[$i] ] = [
                    'value' =>          '',
                    'isError' =>        true,
                    'errorMassage' =>   'Ошибка, в запросе отсутсвует поле '.$listNames[$i],
                ];

                array_push( $errors, true );

            };*/

        };

        if( isset( $data[ PASSWORD ] ) && isset( $data[ PASSWORD_CONFIRMATION ] ) ){
            if( $data[ PASSWORD ] !== $data[ PASSWORD_CONFIRMATION ] ){
                $inputResponse[ PASSWORD_CONFIRMATION ] = [
                    'value' =>          '',
                    'isError' =>        true,
                    'errorMassage' =>   'Была допущена ошибка при повторном вводе пароля',
                ];
                array_push( $errors, true );
            };
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


    protected function process_a_password_reset_request( $data ){

        $email =                    $data['email'];
        $secret_code =              $data['secret_code'];
        $password =                 $data['password'];
        $password_confirmation =    $data['password_confirmation'];

        // email: "dubq@mail.ru"
        // password: ""
        // password_confirmation: ""
        // secret_code: ""

        $result = [];
        $result['errorMassage'] = '';

        $currentStage = $this->to_determine_the_current_stage_of_the_password_reset( $data );

        if( $currentStage === false ){

            /*
                стадия не определена, значит или ошибка или попытка взлома
            */

            $result['ok'] = false;
            $result['errorMassage'] = 'Ошибка при попытке определить стадию сброса пароля';
            $result['data'] = $data;

        }else{

            if( $currentStage === 1 ){
                /*
                    здесь отправляем серкетный код на почту
                */
                $result['nextStage'] = 2;

                $users = new User();
                $user = $users::where( 'email', '=', $email )->first();

                if( isset( $user ) ){

                    $isConfirmed = $user->email_is_confirmed;

                    if( $isConfirmed ){

                        $user->sectet_token_confirmed = $this->get_secret_code();
                        $user->save();

                        $this->send_email_for_reset_password( $email );

                        $result['ok'] = true;

                    }else{
                        $result['ok'] = false;
                        $result['errorMassage'] = 'Ошибка при попытке сбросить пароль. Пользователь не подтвердил e-mail '.$email;

                    };

                }else{
                    $result['ok'] = false;
                    $result['errorMassage'] = 'Ошибка при попытке сбросить пароль. Пользователь с e-mail '.$email.' не зарегистрирован';
                
                };

            }else if( $currentStage === 2 ){
        
                /*
                    здесь проверяем серкетный код введённый пользователем
                */
                $users = new User();
                $user = $users::where( 'sectet_token_confirmed', '=', $secret_code )->first();

                if( isset( $user ) ){
                    $result['ok'] = true;
                    $result['nextStage'] = 3;

                }else{
                    $result['ok'] = false;
                    $result['inputResponse'] = [
                        EMAIL => [
                            'value' =>          '',
                            'isError' =>        false,
                            'errorMassage' =>   '',
                        ],
                        SECRET_CODE => [
                            'value' =>          $secret_code,
                            'isError' =>        true,
                            'errorMassage' =>   'Секретный код введён неверно',
                        ], 
                        PASSWORD => [
                            'value' =>          '',
                            'isError' =>        false,
                            'errorMassage' =>   '',
                        ],
                        PASSWORD_CONFIRMATION => [
                            'value' =>          '',
                            'isError' =>        false,
                            'errorMassage' =>   '',
                        ],
                    ];

                };

            }else if( $currentStage === 3 ){



                $users = new User();
                $user = $users::where( 'email', '=', $email )->first();

                if( isset($user ) ){

                    if( $user->sectet_token_confirmed === $secret_code ){


                        $user->password = $this->get_a_hashed_password( $password );
                        $user->save();

                        $result['ok'] = true;
                        $result['nextStage'] = 4;


                    }else{
                        $result['ok'] = false;
                        $result['nextStage'] = 3;
                        $result['inputResponse'] = [
                            'errorMassage' => 'Данные не подтверждены, хитрожопят с секретным кодом',
                        ];
                    };

    

                }else{
                    $result['ok'] = false;
                    $result['nextStage'] = 3;
                    $result['inputResponse'] = [
                        'errorMassage' => 'Данные не подтверждены, хитрожопят с email',
                    ];
                };

            }else if( $currentStage === false ){
                $result['ok'] = false;
                $result['nextStage'] = 1;
                $result['inputResponse'] = [
                    'errorMassage' => 'Данные не подтверждены, хитрожопят с параметрами запроса. Фу, быть таким!!',
                ];

               
            };

            
        };

        $result['href'] = route( 'login' );

        return $result;


    }



    protected function to_determine_the_current_stage_of_the_password_reset( $inputData ){
        // email: "dubq@mail.ru"
        // password: ""
        // password_confirmation: ""
        // secret_code: ""

        /*
            Варианты возвращаемого значения: 1, 2, 3, false,
        */

        $result;

        $isset_email =                 isset($inputData[ EMAIL ]) && $inputData[ EMAIL ] !== '';
        $isset_secret_code =           isset($inputData[ SECRET_CODE ]) && $inputData[ SECRET_CODE ] !== '';
        $isset_password =              isset($inputData[ PASSWORD ]) && $inputData[ PASSWORD ] !== '';
        $isset_password_confirmation = isset($inputData[ PASSWORD_CONFIRMATION ]) && $inputData[ PASSWORD_CONFIRMATION ] !== '';

        // $stage_1 = $isset_email && !$isset_secret_code && !$isset_password && !$isset_password_confirmation;
        // $stage_2 = !$isset_email && $isset_secret_code && !$isset_password && !$isset_password_confirmation;
        // $stage_3 = !$isset_email && !$isset_secret_code && $isset_password && $isset_password_confirmation;
        $stage_1 = $isset_email && !$isset_secret_code && !$isset_password && !$isset_password_confirmation;
        $stage_2 = $isset_secret_code && !$isset_password && !$isset_password_confirmation;
        $stage_3 = $isset_password && $isset_password_confirmation;

        switch( true ){
            case $stage_1:
                $result = 1;
                break;

            case $stage_2:
                $result = 2;
                break;

            case $stage_3:
                $result = 3;
                break;

            default:
                $result = false;
        };

        return $result;

    }


    // protected function add_new_user_into_database( $userInfo ){

    //     $res = User::create([
    //         NAME =>           $userInfo[ NAME ],
    //         EMAIL =>          $userInfo[ EMAIL ],
    //         PASSWORD =>       bcrypt( $userInfo[ PASSWORD ] ),
    //         'sectet_token_confirmed' => $this->get_token(),
    //     ]);

    //     return [
    //         'ok' => $res,
    //     ];

    // }


    protected function get_secret_code() {
        $secret_code = sprintf(
            '%04x%04x%04x',

            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff)
        );
     
        return $secret_code;
    }











    


};

