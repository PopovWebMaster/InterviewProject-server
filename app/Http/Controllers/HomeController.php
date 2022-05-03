<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;

use Auth; // врем удалить !!!!!!!!!!!!!

use Mail;

class HomeController extends SiteController
{
    
    public function __construct()
    {
        parent::__construct();

    }

    public function get()
    {
        $data = [];

        // Mail::send('mail', [], function ($massage){
        //     $massage->to('dubq@mail.ru', '')->subject('Проба пера');
        //     $massage->from('popovalexandrdnr84@gmail.com', 'Your Application');
            
        // });


        Mail::send('mail', [], function ($massage){
            $massage->to('linaqwe123@mail.ru', '')->subject('Аничка привет от моего приложения');
            $massage->from('popovalexandrdnr84@gmail.com', 'Your Application');
            
        });

        $this->setJson([
            'section_id_name' => 'home',
        ]);
            
        if( view()->exists('default.home') ){
            return view( 'default.home', $this->data );
        };
        abort(404);
    }
}
