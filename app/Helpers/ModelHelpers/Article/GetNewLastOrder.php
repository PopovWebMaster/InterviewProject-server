<?php

namespace App\Helpers\ModelHelpers\Article;

use App\Article;

class GetNewLastOrder{
    
    static public function make(){ 
        $articles = Article::get();
        $maxOrder = 0;
        foreach( $articles as $item ){
            if( $item->order > $maxOrder ){
                $maxOrder = $item->order;
            };
        };
        $lastOrder = $maxOrder+1;
        return $lastOrder;
    }

};

