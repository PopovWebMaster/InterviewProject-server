<?php 

namespace App\Http\Controllers\Auth\AuthTraits;

use Config;
use Validator;

trait AuthMethodsTrait {

    protected function to_mount_the_shared_constants(){

        define( 'NAME',                     'name' );
        define( 'EMAIL',                    'email' );
        define( 'PASSWORD',                 'password' );
        define( 'PASSWORD_CONFIRMATION',    'password_confirmation' );
        define( 'SECRET_CODE',              'secret_code' );

        define( 'CHECK_FIELD',          Config::get('my_actions.registration.checkField') ); 
        define( 'TRY_TO_ACCEPT',        Config::get('my_actions.registration.tryToAccept') );

    }

    private function getListInputMaxLength(){
        return [
            NAME =>                     255,
            EMAIL =>                    255,
            PASSWORD =>                 255,
            PASSWORD_CONFIRMATION =>    255,
            SECRET_CODE =>              250,
        ];
    }

    protected function get_a_shared_properties_object(){
        return [
            'value' =>          '',
            'isError' =>        false,
            'errorMassage' =>   ''
        ];
    }

    private function getAListOfActionsAsAString(){

        $arr_registration =             Config::get('my_actions.registration');
        $arr_authorization =            Config::get('my_actions.authorization');
        $arr_password_confirmation =    Config::get('my_actions.password_confirmation');

        $result = '';

        function addAction( $action, &$result ){
            if( $result === '' ){
                $result = $result.$action;
            }else{
                $result = $result.','.$action;
            };
        };

        foreach( $arr_registration as $key => $value ){
            addAction( $value, $result );
        };

        foreach( $arr_authorization as $key => $value ){
            addAction( $value, $result );
        };

        foreach( $arr_password_confirmation as $key => $value ){
            addAction( $value, $result );
        };

        return $result;

    }

    protected function checkActionRequest( $action = null ){

        $result = [
            'ok' => null,
            'errors' => null,
        ];

        if( isset( $action ) ){

            $actions_as_a_string = $this->getAListOfActionsAsAString();

            $validator = Validator::make( [
                'action' => $action,
            ], [
                'action' => 'required|string|alpha_num|in:'.$actions_as_a_string,
            ] );

            if( $validator->fails() ){

                $result[ 'ok' ] =       false;
                $result[ 'errors' ] =   $validator->getMessageBag()->all();

            }else{
                $result[ 'ok' ] =       true;
                $result[ 'errors' ] =   [];
            };

        }else{

            $result[ 'ok' ] =       false;
            $result[ 'errors' ] =   [ 'В метод checkActionRequest не был передан параметр $action' ];

        };

        return $result;

    }


    protected function get_a_hashed_password( $str ){

        return bcrypt( $str );

    }



};










?>