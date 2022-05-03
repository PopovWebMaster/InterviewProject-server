<?php

namespace App\Helpers\ModelHelpers\Article;

use App\Article;

class UpdateOrders{
    /*
            Перед применением метода, все проверки на корректность принимаемых параметров уже 
        должны быть произведены
    
    */
    static public function make(){ 

        $articles = new Article();
        $arr = $articles->get();
        $arrOrderId = [];
        foreach( $arr as $item ){
            $arrOrderId[ $item->order ] = $item->id;
        };
        ksort( $arrOrderId );

        $i = 1;
        foreach( $arrOrderId as $order => $id ){
            $article = $articles->find( $id );
            $article->order = $i;
            $article->save();
            $i++;
        };


        
    }
    
};


?>