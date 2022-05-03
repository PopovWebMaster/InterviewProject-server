<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use App\User;

class ConfirmEmailController extends Controller
{
    public function get( $token = null ){

        if( isset($token) ){

            $validator = Validator::make( 
                ['token' => $token ], 
                ['token' => 'required|alpha_num|size:32' ] );
            if( $validator->fails() ){
                // dd($validator->getMessageBag()->all());
                return redirect()->route('home');  
            };

            $user = User::where( 'sectet_token_confirmed', '=', $token )->first();

            if( isset( $user ) ){

                $user->email_is_confirmed = true;
                $user->sectet_token_confirmed = '';
                $user->save();

                return redirect()->route( 'login' );

            }else{
                return redirect()->route('home');
            };

            return 'Подтверждено '.$token.' длина'.strlen($token);
        }else{
            return redirect()->route('home');
        };

        
    }
}

// "c7cea89df70f4dc4bf45d18b6875a629 ------ 32"
// "c4a42ec747e74317aa76ea361b2aff73 ------ 32"
// "1a9f57753cd448bfa6d7155374dd373d ------ 32"
// "fde4133214ef41f5a44d646f2890e527 ------ 32"
// "5dc09716f7244477889fa624d06f01c3 ------ 32"
// "a5c175a15bf4415382d6c5a75a482978 ------ 32"
// "985654aa9b3c498288cb96290d739fc6 ------ 32"
// "f1b01b89ae684f4880882dab693738b6 ------ 32"
// "85101ff6e38a4a4bab8c8a90a24f04cb ------ 32"
