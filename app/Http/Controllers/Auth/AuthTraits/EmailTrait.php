<?php 

namespace App\Http\Controllers\Auth\AuthTraits;

use Config;
use Validator;
use Auth;
use App\Dictionaries;
use App\User;
// use App\Projects;
use App\Settings;
use App\ResetPassword;

use Mail;


// use App\Http\Controllers\Auth\AuthController;

trait EmailTrait {


    protected function send_an_email_to_confirm_the_users_email_address( $params ){ 

        $email = $params['email'];
        $ok = false;
        $errorMassage = '';

        if( $this->get_status_of_the_email_confirmation_in_the_settings() ){ 

            $result_of_sending = $this->send_email_confirmation( $email );

            $ok = $result_of_sending['ok'];
            $errorMassage = $result_of_sending['errorMassage'];
        };

        return [
            'ok' => $ok,
            'errorMassage' => $errorMassage,
        ];

    }

    private function send_email_confirmation( $email ){

        $user = User::where('email', '=', $email )->first();
        $token = $user->sectet_token_confirmed;

        $settings = new Settings();

        $site_name_part_1 = $settings->get_a_value_for_a_single_setting( 'site_name_part_1' );
        $site_name_part_2 = $settings->get_a_value_for_a_single_setting( 'site_name_part_2' );

        $data = [
            'email' => $email,
            'token' => $token,
            'site_name' => $site_name_part_1.' '.$site_name_part_2,
            'site_name_part_1' => $site_name_part_1,
            'site_name_part_2' => $site_name_part_2,
        ];

        Mail::send('email.confirm_email', $data, function ($massage) use( $data ){
            $massage->to( $data['email'], '')->subject( 'Подтверждение регистрации');
            $massage->from('popovalexandrdnr84@gmail.com', $data['site_name'] );
            
        });

        return [
            'ok' => true,
            'errorMassage' => '',
        ];
    }












    private function send_email_for_reset_password( $email ){

       
        $user = User::where('email', '=', $email )->first();

        $settings = new Settings();

        $site_name_part_1 = $settings->get_a_value_for_a_single_setting( 'site_name_part_1' );
        $site_name_part_2 = $settings->get_a_value_for_a_single_setting( 'site_name_part_2' );

        $secret_code = $user->sectet_token_confirmed;

        $data = [
            'email' => $email,
            'secret_code' => $secret_code,
            'site_name' => $site_name_part_1.' '.$site_name_part_2,
            'site_name_part_1' => $site_name_part_1,
            'site_name_part_2' => $site_name_part_2,
        ];


        Mail::send('email.reset_password', $data, function ($massage) use( $data ){
            $massage->to( $data['email'], '')->subject( 'Сброс пароля');
            $massage->from('popovalexandrdnr84@gmail.com', $data['site_name'] );
            
        });

        return [
            'ok' => true,
            'errorMassage' => '',
        ];


        







        // $token = $user->sectet_token_confirmed;

        // $settings = new Settings();

        // $site_name_part_1 = $settings->get_a_value_for_a_single_setting( 'site_name_part_1' );
        // $site_name_part_2 = $settings->get_a_value_for_a_single_setting( 'site_name_part_2' );

        // $data = [
        //     'email' => $email,
        //     'token' => $token,
        //     'site_name' => $site_name_part_1.' '.$site_name_part_2,
        //     'site_name_part_1' => $site_name_part_1,
        //     'site_name_part_2' => $site_name_part_2,
        // ];

        // Mail::send('email.confirm_email', $data, function ($massage) use( $data ){
        //     $massage->to( $data['email'], '')->subject( 'Подтверждение регистрации');
        //     $massage->from('popovalexandrdnr84@gmail.com', $data['site_name'] );
            
        // });

        // return [
        //     'ok' => true,
        //     'errorMassage' => '',
        // ];
    }












    private function get_status_of_the_email_confirmation_in_the_settings(){

        $result = null;
        $setting = Settings::where('name', '=', 'sending_a_message_during_registration')->first();

        if( $setting->value === 'true' ){
            $result = true;

        }else if( $setting->value === 'false' ){
            $result = false;

        };

        return $result;

    }


    protected function check_the_users_email_for_confirmation( $params ){

        $email = $params['email'];
        $result;

        if( $this->get_status_of_the_email_confirmation_in_the_settings() ){
            $user = User::where( 'email', '=', $email )->first();
            $result = (boolean) $user->email_is_confirmed;

        }else{
            $result = true;
        };

        return $result;



    }


};




?>