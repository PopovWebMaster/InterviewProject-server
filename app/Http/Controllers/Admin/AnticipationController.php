<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnticipationController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();

        $this->setJson([
            'currentPage'=>'ANTICIPATION' 
        ]);
    }
    
    public function get(){

        if( view()->exists('admin.anticipationAdmin') ){
            return view( 'admin.anticipationAdmin', $this->data );
        };
        abort(404);

    }

    public function post( Request $request ){
        dump($request->all());
        $data = [
            'a'=> 'aaaa',
            'b'=> 'bbbb'

        ];


        

        return response()->json( $data );
        //return $data;

    }
}
