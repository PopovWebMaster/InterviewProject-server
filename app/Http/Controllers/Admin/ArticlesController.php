<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

class ArticlesController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();
  
    }
    
    public function get(){
		
        $articles = new Article;
		
		$this->setJson([
            'currentPage'=>'ARTICLES',
            'listArticles' => $articles->getListArticles(),
			'href_add_article' => route('admin_addarticle')
        ]);
		
        if( view()->exists('admin.articlesAdmin') ){
            return view( 'admin.articlesAdmin', $this->data );
        };
        abort(404);
        
    }

    // public function post( Request $request ){}
}
