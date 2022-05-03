<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;

use Config;
use Validator;

class AddArticleController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();
  
    }
    public function get(){

		$articles = new Article;
        $arr = $articles->get();
        $arrListOfTitles = [];
        $arrListOfAliases = [];
        foreach( $arr as $k ){
            array_push( $arrListOfTitles, $k->title );
            array_push( $arrListOfAliases, $k->alias );
            
		};
		
		$this->setJson([
            'currentPage'=>'ADD_ARTICLE',
			'arrListOfTitles' => $arrListOfTitles,
			'arrListOfAliases' => $arrListOfAliases,
			'href_for_post' => route( 'admin_addarticle' )
        ]);

        if( view()->exists('admin.addArticleAdmin') ){
            return view( 'admin.addArticleAdmin', $this->data );
        };
        abort(404);
        
    }

    public function post( Request $request ){
		/*
			action: 'AddNewArticle'
			params = {
				title: this.state.title,
				second_title: this.state.second_title,
				alias: this.state.alias,
				text: this.state.text
			};
        */

        $this->connectsConstants();
        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            return [
                'ok' => false, 
                // 'request' => $request->params,
                // 'comment' => ' не прошло',
                // 'massage' => $validator->getMessageBag()->all()
            ];
        };

        if( $request->action === ADD_NEW_ARTICLE ){

            $article = new Article;
            $article->addNewArticle( $request->params );
        
        };

        return [
            'ok' => true, 
            'href' => route('admin_articles' )
        ];
		

    }



    private function getCheckArray( $request ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, что бы сделать из того что прийдёт в $request, массив с уникальными полями, 
        // а данные уникальные поля уже потом можно было использовать в validation.php для создания корректных, уникальных
        // сообщений об ошибках валидации

        $checkArray = [];

        if( isset( $request->action ) ){
            $checkArray['action'] = $request->action;
        };
        
        if( isset( $request->params['title'] ) ){
            $checkArray[ TITLE ] = $request->params['title'];
        };

        if( isset( $request->params['second_title'] ) ){
            $checkArray[ SECOND_TITLE ] = $request->params['second_title'];
        };

        if( isset( $request->params['alias'] ) ){
            $checkArray[ NEW_ALIAS ] = $request->params['alias'];
        };

        if( isset( $request->params['text'] ) ){
            $checkArray[ TEXT ] = $request->params['text'];
        };

        return $checkArray;

    }

    private function getRulesValidation( $request ){

        $regex_alias =  Config::get('my_config.regex.alias');
        $regex_text =   Config::get('my_config.regex.articleText');

        $rules = [];

        $rules['action'] = 'required|string|alpha_num|in:'.ADD_NEW_ARTICLE;

        if( $request->action === ADD_NEW_ARTICLE ){

            $rules[ TITLE ] =        'required|string|unique:articles,title|regex:'.$regex_text;
            $rules[ SECOND_TITLE ] = 'required|string|regex:'.$regex_text;
            $rules[ NEW_ALIAS ] =    'required|string|unique:articles,alias|regex:'.$regex_alias;
            $rules[ TEXT ] =         'required|string';
        };

        return $rules;
        
    }


    private function connectsConstants(){

        define( 'ADD_NEW_ARTICLE',   'AddNewArticle' );

        define( 'TITLE',        Config::get('my_config.request_nickname.article.title') );
        define( 'SECOND_TITLE', Config::get('my_config.request_nickname.article.second_title') );
        define( 'NEW_ALIAS',    Config::get('my_config.request_nickname.article.alias') );
        define( 'TEXT',         Config::get('my_config.request_nickname.article.text') );

    }


}
