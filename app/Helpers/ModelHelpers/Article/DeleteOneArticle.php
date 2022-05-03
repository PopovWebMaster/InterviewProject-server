<?php

namespace App\Helpers\ModelHelpers\Article;

use App\Article;

use App\Helpers\ModelHelpers\Article\UpdateOrders;

class DeleteOneArticle{
    /*
            Перед применением метода, все проверки на корректность принимаемых параметров уже 
        должны быть произведены
    
    */
    static public function make( $alias ){ 

        $articles = new Article();
        $article = $articles->where('alias', '=', $alias)->first();
        $article->delete();

        UpdateOrders::make();
        
    }
    
};


?>