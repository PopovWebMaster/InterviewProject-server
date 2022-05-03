<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\User;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    
    public function get(){

        if( Auth::check() ){

            $id = Auth::id();
            $user = User::find( $id );

            if( $user->access ){
                return redirect()->route('admin_home');
            }else{
                return redirect()->route('login');
            };

        }else{
            return redirect()->route('login');
        };

    }

}
