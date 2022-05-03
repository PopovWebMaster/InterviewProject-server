<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SiteController;

use App\Http\Controllers\Auth\AuthTraits\LoginTrait;

use Auth;

class LoginController extends SiteController
{

    use LoginTrait;

    public function __construct()
    {
        parent::__construct();

        $this->connectsConstants_to_login();

    }

    public function get()
    {

        if( Auth::check() ){
            return redirect()->route('home');
        };

        $this->data['section_id_name'] = 'authorization';
        $this->data['showAuthPanel'] = false;
        
        $this->setJson( $this->get_a_json_message_to_login() );

        if( view()->exists('default.authorization') ){
            return view( 'default.authorization', $this->data );
        };
        abort(404);
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

                $result_of_check = $this->check_one_field_login( [ 'inputName' => $inputName, 'value' => $value ] );

                return [
                    'inputName' =>      $request->data['inputName'],
                    'value' =>          $request->data['value'],
                    'isError' =>        $result_of_check['isError'],
                    'errorMassage' =>   $result_of_check['errorMassage'],
                ];


            }else if( $request->action === TRY_TO_ACCEPT ){ // попытка записать пользовательские данные в ДБ

                $result_of_data_verification = $this->check_all_input_field_data( $request->data );

                $inputResponse = $result_of_data_verification[ 'inputResponse' ];

                $result = [
                    'ok' => false,
                    'inputResponse' => $inputResponse,
                    'href' => null,
                ];

                if( $result_of_data_verification[ 'ok' ] ){

                    $email =    $inputResponse[ EMAIL ]['value'];
                    $password = $inputResponse[ PASSWORD ]['value'];

                    if( $this->check_the_users_email_for_confirmation( ['email' => $email ] ) ){

                        $resultAuth = Auth::attempt([
                            'email' =>      $email, 
                            'password' =>   $password,
                        ]);

                        if ( $resultAuth ) {
                            $result['ok'] = true;
                            $result['href'] = route( 'dictionaries' );
                        
                        }else{
                            $result['ok'] = false;
                            $result['inputResponse'][ PASSWORD ] = [
                                'value' => '',
                                'isError' => true,
                                'errorMassage' => 'Неверно введён пароль',
                            ];
                        }; 

                    }else{
                        $result['ok'] = false;
                        $result['is_email_confirmed'] = false;

                    };

                }else{
                    $result['ok'] = false;
                };

                return $result;


            }else if( $request->action === CONFIRM_EMAIL_AGAIN ){

                $result = [
                    'ok' => false,
                    'href' => null,
                    'errorMassage' => '',
                ];

                $inputName =    $request->data['inputName'];
                $value =        $request->data['value'];

                $result_of_check = $this->check_one_field_login([ 
                    'inputName' =>  $inputName, 
                    'value' =>      $value 
                ]);


                if( !$result_of_check['isError'] ){ // адрес нормальный

                    $resSending = $this->send_an_email_to_confirm_the_users_email_address( [
                        'email' => $value,
                    ]);

                    if( $resSending['ok'] ){
                        $result['ok'] = true;
                        $result['href'] = route( 'information_massage', [ 'typeMassage' => 'my-type-massage-confirm-email' ] );

                    }else{
                        $result['ok'] = false;
                        $result['errorMassage'] = $resSending['errorMassage'];
                    };


                }else{
                    $result['ok'] = false;
                    $result['errorMassage'] = 'e-mail адрес не валидный';
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
