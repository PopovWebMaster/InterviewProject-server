<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;

use CreateArrFromArticleModel;

class Home extends SiteController {

    public function __construct(){
        parent::__construct();
        

    }

    public function show( Article $article ){


        $this->data['title'] = 'Проверочка';

        if( view()->exists('default.home') ){
            return view( 'default.home', $this->data );
        };
        abort(404);

        
    }
}
