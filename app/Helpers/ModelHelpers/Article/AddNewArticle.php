<?php

namespace App\Helpers\ModelHelpers\Article;

use App\Helpers\ModelHelpers\Article\GetNewLastOrder;

use App\Article;

class AddNewArticle{
    
    static public function make( $params ){ 

        $article = new Article();

        $article->title =        $params['title'];
        $article->second_title = $params['second_title'];
        $article->alias =        $params['alias'];
        $article->order =        GetNewLastOrder::make();
        $article->status =       false;
        $article->text =         $article->getEncodedText( $params['text'] );

        $article->save();

    }

};

?>
