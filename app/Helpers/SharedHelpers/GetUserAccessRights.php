<?php

namespace App\Helpers\SharedHelpers;

// use App\Settings;
use App\User;
use Auth;

class GetUserAccessRights {

    static public function isAdmin(){

        $result = false;

        if( Auth::check() ){

            $id = Auth::id();
            $user = User::find( $id );

            if( isset( $user->access['access_right'] ) ){
                if( $user->access['access_right'] === 'admin' ){
                    $result = true;
                };
            }; 

        };

        return $result;

    }


}


?>