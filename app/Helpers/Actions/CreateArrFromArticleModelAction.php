<?php  

namespace App\Helpers\Actions;

use App\Helpers\Contracts\CreateArrFromArticleModel;
use App\Article;
 

class CreateArrFromArticleModelAction implements CreateArrFromArticleModel {

    public static function get(){

        $orders = [];
        $result = [];

        $ARTICLES = new Article();
        $articles = $ARTICLES->all();
        
        foreach( $articles as $k ){
            $orders[] = $k['order'];
        };
        asort($orders);
         
        foreach( $orders as $k ){
            $article = $ARTICLES::where('order','=', $k )->get();
            if( $article[0]->status ){
                $text = $ARTICLES->getDecodedText( $article[0]->text );
                $arr = [
                    'title' => $article[0]->title,
                    'second_title' => $article[0]->second_title,
                    'alias' => $article[0]->alias,
                    'text' => $text,
                ];
                array_push( $result, $arr );
            };
 
        };


        return $result;
    }

};















?>