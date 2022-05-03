<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SiteController;

use App\Http\Controllers\Auth\AuthTraits\PasswordResetTrait;
use App\Http\Controllers\Auth\AuthTraits\EmailTrait;

use Validator;
use Config;
use Auth;
use Mail;

use App\ResetPassword;

class PasswordResetController extends SiteController
{
    use PasswordResetTrait;
    use EmailTrait;
    public function __construct()
    {
        parent::__construct();

        $this->connectsConstants_to_reset_password();

        // $this->RUN_TESTS_PasswordResetTrait(); //  не удалять !!!!!!!!

    }

    public function get()
    {

        if( Auth::check() ){
            return redirect()->route('home');

        }else{

            $this->data['section_id_name'] = 'reset_password';
            $this->data['showAuthPanel'] = true;

            $this->setJson( $this->get_a_json_message_to_reset_password() );

            if( view()->exists( 'default.reset_password' ) ){
                return view( 'default.reset_password', $this->data );
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

                $result_of_check = $this->check_one_field_reset_password( [ 'inputName' => $inputName, 'value' => $value ] );

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


                    $result_processed = $this->process_a_password_reset_request( $request->data );

                    if( $result_processed['ok'] ){
                        return [
                            'ok' =>                 true,
                            'nextStage' =>          $result_processed['nextStage'],
                            'href' =>               $result_processed['href'],
                        ];
                    }else{
                        return [
                            'ok' =>                 false,
                            'inputResponse' =>      $result_processed['inputResponse'],
                            
                        ];
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
