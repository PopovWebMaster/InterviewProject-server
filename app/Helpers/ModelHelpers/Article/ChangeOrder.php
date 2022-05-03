<?php

namespace App\Helpers\ModelHelpers\Article;

use App\Article;


class ChangeOrder{
    /*
            Перед применением метода, все проверки на корректность принимаемых параметров уже 
        должны быть произведены
    
    */
    static public function make( $current_order, $next_order ){ 
        if( (int)$current_order === (int)$next_order ){
            return ;
        };

        $articles = new Article;
        $arrArticles = $articles->get();

        $arr = []; // массив всех ордеров и id
        foreach( $arrArticles as $item ){
            $arr[ $item->order ] = $item->id;
        };

        ksort( $arr );

        $arr_2 = []; // исключаем текущие order и id
        $current_id;
        foreach( $arr as $k => $v){
            if( (int)$k === (int)$current_order ){
                $current_id = $v;
            }else{
                $arr_2[$k] = $v;
            };
        };

        $arr_3 = []; // ставим текущий на место следующего
        $i = 1;
        foreach( $arr_2 as $k => $v ){
            if( (int)$k === (int)$next_order ){
                $arr_3[ $i ] = $current_id;
                $i++;
                $arr_3[ $i ] = $v;
            }else{
                $arr_3[ $i ] = $v;
            };
            $i++;
        };

        foreach( $arr_3 as $order => $id ){
                $article = $articles::find( $id );
                $article->order = $order;
                $article->save();
        };

    }

};