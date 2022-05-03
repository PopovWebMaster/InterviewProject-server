<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SiteController;

use Validator;
use Config;
use Auth;
use Mail;


// use App\User;

// use App\Settings;

use App\Http\Controllers\Auth\AuthTraits\RegisterTrait;
use App\Http\Controllers\Auth\AuthTraits\EmailTrait;

class RegisterController extends SiteController
{
    
    use RegisterTrait;
    use EmailTrait;

    public function __construct()
    {
        parent::__construct();

        $this->connectsConstants_to_register();

    }

    public function get()
    {


        if( Auth::check() ){
            return redirect()->route('home');

        }else{

            $this->data['section_id_name'] = 'registration';
            $this->data['showAuthPanel'] = false;

            $this->setJson( $this->get_a_json_message_to_register() );

            if( view()->exists( 'default.registration' ) ){
                return view( 'default.registration', $this->data );
            };

            abort(404);

        };
    }


    public function post( Request $request ){

        if( Auth::check() ){
            return ;
        };

        $result_of_checking_the_action = $this->checkActionRequest( $request->action );

        if( $result_of_checking_the_action['ok'] ){

            if( $request->action === CHECK_FIELD ){ // проверка отдельно взятого input

                $inputName =    $request->data['inputName'];
                $value =        $request->data['value'];

                $result_of_check = $this->check_one_field_register( [ 'inputName' => $inputName, 'value' => $value ] );

                return [
                    'inputName' =>      $request->data['inputName'],
                    'value' =>          $request->data['value'],
                    'isError' =>        $result_of_check['isError'],
                    'errorMassage' =>   $result_of_check['errorMassage'],
                ];


            }else if( $request->action === TRY_TO_ACCEPT ){ // попытка записать пользовательские данные в ДБ

                $result_of_data_verification = $this->check_all_input_field_data( $request->data );

                $result = [
                    'ok' => false,
                    'inputResponse' => $result_of_data_verification[ 'inputResponse' ],
                    'href' => null,
                ];

                if( $result_of_data_verification[ 'ok' ] ){

                    $add_result = $this->add_new_user_into_database( [
                        NAME =>                     $result[ 'inputResponse' ][NAME]['value'],
                        EMAIL =>                    $result[ 'inputResponse' ][EMAIL]['value'],
                        PASSWORD =>                 $result[ 'inputResponse' ][PASSWORD]['value'],
                        PASSWORD_CONFIRMATION =>    $result[ 'inputResponse' ][PASSWORD_CONFIRMATION]['value'],
                    ] );

                    if( $add_result['ok'] ){

                        $this->send_an_email_to_confirm_the_users_email_address([
                            'email' => $result[ 'inputResponse' ][EMAIL]['value'],
                        ]);

                        $result['ok'] = true;

                        if( $this->get_status_of_the_email_confirmation_in_the_settings() ){
                            $result['href'] = route( 'information_massage', [ 'typeMassage' => 'my-type-massage-confirm-email' ] );

                        }else{
                            $result['href'] = route( 'login' );

                        };


                    }else{
                        $result['ok'] = false;

                    };

                }else{
                    $result['ok'] = false;
                };

                return $result;


            };

        }else{

            // Ошибка, а в $request что-то не так с action
            return [
                'isError' => true,
                'errorMassage' =>  $result_of_checking_the_action['errors'][0],
                'request_data' => $request->data,
            ];

        };

     
    }



}
