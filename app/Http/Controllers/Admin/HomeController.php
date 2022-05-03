<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();

        $this->setJson([
            'currentPage'=>'HOME' 
        ]);
    }

    public function get(){

        //dump( $this->data );
        if( view()->exists('admin.homeAdmin') ){
            return view( 'admin.homeAdmin', $this->data );
        };
        abort(404);

        
    }

    public function post( Request $request ){
        /*
        dump($request->all());
        $data = [
            'a'=> 'aaaa',
            'b'=> 'bbbb'

        ];


        

        return response()->json( $data );*/
        return '';

    }
}