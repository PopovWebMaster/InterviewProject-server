<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;

class AdminWorkspaceController extends Controller
{
    
    
    public function show(){
        return view('admin.workspace');

        //return 'Рабочее пространство админки';
    }

    public function vrem( Request $request ){
        dump($request->all());
        $data = [
            'a'=> 'aaaa',
            'b'=> 'bbbb'

        ];


        

        return response()->json( $data );
        //return $data;

    }
}
