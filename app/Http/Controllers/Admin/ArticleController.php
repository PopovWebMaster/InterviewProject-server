<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;

use Config;
use Validator;

use App\Helpers\ModelHelpers\Article\GetNewLastOrder;

class ArticleController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();
  
    }
    
    public function get( $alias ){

        $articles = new Article;
        $article = $articles->where('alias', '=', $alias )->first();

        $arr = $articles->get();
        $arrListOfTitles = [];
        $arrListOfAliases = [];
        $arrListOfOrders = [];

        foreach( $arr as $k ){
            array_push( $arrListOfTitles, $k->title );
            array_push( $arrListOfAliases, $k->alias );
            array_push( $arrListOfOrders, $k->order );
            
        };

		$this->setJson([
            'currentPage'=>'ARTICLE',
            'title' => $article->title,
            'second_title' => $article->second_title,
            'alias' => $article->alias, 
            'order' => $article->order,
            'text' => $articles->getDecodedText( $article->text ),
            'status' => $article->status,
            'href_for_post' => route('admin_article', [ 'alias' => $alias ] ),
            'arrListOfTitles' => $arrListOfTitles,
            'arrListOfAliases' => $arrListOfAliases,
            'arrListOfOrders' => $arrListOfOrders
        ]);

        $this->data['title'] = $article->title;
		
        if( view()->exists('admin.articleAdmin') ){
            return view( 'admin.articleAdmin', $this->data );
        };
        abort(404);
        
    }

    public function post( Request $request, $alias ){

        // Пример 
        //     alias: "aaaaaa"
        //     action: "setNewParamsOneArticle"
        //     articleTitle: "Вторая статеечка новая"
        //     articleSecond_title: "Слога всё-таки нужен"
        //     articleAlias: "newalias"
        //     articleOrder: "2"
        //     articleStatus: "true"
        //     articleText: "<p>Проба пера, такой пишу себе

        $this->connectsConstants();
        $rules = $this->getRulesValidation( $request );
        $checkArray = $this->getCheckArray( $request, $alias );

        $validator = Validator::make( $checkArray, $rules );
        if( $validator->fails() ){
            $text_with = htmlentities($request->params['text']);
            return [
                'ok' => false, 
                'request' => $request->params,
                'comment' => ' не прошло',
                'text' =>  html_entity_decode($text_with),
                'text_with' => $text_with,
                'massage' => $validator->getMessageBag()->all()
            ];
        };

        $articles = new Article();

        $check_article = $articles::where('alias', '=', $alias )->first();
        if( is_null($check_article) ){
            return [
                'ok' => false,
                'massage' => 'Не существует статьи с таким $alias '.$alias
            ];
        };

        $article_id = $check_article->id;

		if( $request->action === SET_NEW_PARAMS_ONE_ARTICLE ){
			/*
				$request->params = [
					'title' => '',
					'second_title' => '',
					'alias' => '',
					'order' => '',
					'status' => '',
					'text' => ''
				]
            */

            $articles = new Article;
            $res = $articles->setNewParamsOneArticle( $request->params, $alias );

            return [
                'ok' => $res['ok'],
                'errors' => $res['errors'],
                'href' => route('admin_article', [ 'alias' => $res['alias'] ] )
            ];
	
		}else if( $request->action === DELETE_ARTICLE ){
			
			$article = new Article;
            $article->deleteArticle( $alias );
            return [
                'href' => route('admin_articles' ),
            ];
			
        };
        
    }

    private function getCheckArray( $request, $alias ){

        // Данный метод создаёт массив предназначенный для использования в валидации
        // Его смысл в том, что бы сделать из того что прийдёт в $request, массив с уникальными полями, 
        // а данные уникальные поля уже потом можно было использовать в validation.php для создания корректных, уникальных
        // сообщений об ошибках валидации


        $checkArray = [];
        $checkArray['alias'] = $alias;

        if( isset( $request->action ) ){
            $checkArray['action'] = $request->action;
        };

        if( isset( $request->params['title'] ) ){
            $checkArray[ TITLE ] = $request->params['title'];
            //$checkArray[ TITLE ] = '.-?,:;!=+@#$%&*()';
        };

        if( isset( $request->params['second_title'] ) ){
            $checkArray[ SECOND_TITLE ] = $request->params['second_title'];
        };

        if( isset( $request->params['alias'] ) ){
            $checkArray[ NEW_ALIAS ] = $request->params['alias'];
        };

        if( isset( $request->params['order'] ) ){
            $checkArray[ ORDER ] = $request->params['order'];
        };

        if( isset( $request->params['status'] ) ){
            $checkArray[ STATUS ] = $request->params['status'];
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
        $rules['action'] = 'required|string|alpha_num|in:'.SET_NEW_PARAMS_ONE_ARTICLE.','.DELETE_ARTICLE;
        $rules['alias'] = 'required|string|regex:'.$regex_alias;

        if( $request->action === SET_NEW_PARAMS_ONE_ARTICLE ){

            $rules[ TITLE ] =        'required|string|regex:'.$regex_text;
            $rules[ SECOND_TITLE ] = 'string|regex:'.$regex_text;
            $rules[ NEW_ALIAS ] =    'required|string|regex:'.$regex_alias;
            $rules[ ORDER ] =        'required|integer|digits_between:1,3|min:1';
            $rules[ STATUS ] =       'required|in:true,false';
            $rules[ TEXT ] =         'required|string';

        }/*else if( $request->action === DELETE_ARTICLE ){
            Правила для DELETE_ARTICLE отсутствуют
        }*/;
        
        return $rules;
        
    }

    private function connectsConstants(){

        define( 'SET_NEW_PARAMS_ONE_ARTICLE',   'setNewParamsOneArticle' );
        define( 'DELETE_ARTICLE',               'deleteArticle'  );

        define( 'TITLE',        Config::get('my_config.request_nickname.article.title') );
        define( 'SECOND_TITLE', Config::get('my_config.request_nickname.article.second_title') );
        define( 'NEW_ALIAS',    Config::get('my_config.request_nickname.article.alias') );
        define( 'ORDER',        Config::get('my_config.request_nickname.article.order') );
        define( 'STATUS',       Config::get('my_config.request_nickname.article.status') );
        define( 'TEXT',         Config::get('my_config.request_nickname.article.text') );

    }
























}
