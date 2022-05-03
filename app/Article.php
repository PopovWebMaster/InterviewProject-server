<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\ModelHelpers\Article\ChangeOrder;
use App\Helpers\ModelHelpers\Article\DeleteOneArticle;
use App\Helpers\ModelHelpers\Article\AddNewArticle;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [ 'title', 'second_title', 'alias', 'order', 'status', 'text', 'updated_at' ];

    public function getListArticles(){
        $arr = $this->get();
        $list = [];
        
        foreach( $arr as $item ){
            $obj = [
                'id' => $item->id,
                'title' => $item->title,
                'second_title' => $item->second_title,
                'alias' => $item->alias,
                'href_article' =>  route( 'admin_article', [ 'alias' => $item->alias ] ),
                'status' => $item->status,
                'order' => $item->order,
                'text' => $this->getDecodedText( $item->text ),
            ];
            array_push( $list, $obj );

        };
        return $list;

    }

    public function setNewParamsOneArticle( $params, $alias ){
        
        $article = $this::where('alias', '=', $alias )->first();
        $id = $article->id;

        if( isset( $params['title'] ) ){
            $article->title = $params['title'];
        };
        if( isset( $params['second_title'] ) ){
            $article->second_title = $params['second_title'];
        };
        if( isset( $params['alias'] ) ){
            $article->alias = $params['alias'];
        };
        if( isset( $params['status'] ) ){
            if( $params['status'] === 'true'){
                $article->status = true;
            }else{
                $article->status = false;
            };
        };
        if( isset( $params['text'] ) ){
            $article->text = $this->getEncodedText( $params['text'] );
        };
        if( isset( $params['order'] ) ){

            $next_order = $params['order'];
            $current_order = $article->order;
            $reschange = $this->changeOrder( $current_order, $next_order );
            if( $reschange['ok'] === false ){
                return [
                    'ok' => false,
                    'errors' => $reschange['errors'],
                    'alias' => $alias,
                ];
            };
        };

        $article->save();

        $newAlias = $this->getAlias( $id );
        return [
            'ok' => true,
            'errors' => '',
            'alias' => $newAlias,
        ];
        
    }

    private function changeOrder( $current_order, $next_order ){
       
        $errors = [];
        $isError = false;

        // Блок проверки 
        $is_current_order = $this::where('order', '=', $current_order )->first();
        $is_next_order  = $this::where('order', '=', $next_order )->first();
        if( is_null( $is_current_order ) ){
            $isError = true;
            $str = 'Не существует в БД статьи с таким ордером '.$current_order.'($current_order)';
            array_push( $errors, $str );
        };
        if( is_null( $is_next_order ) ){
            $isError = true;
            $str = 'Не существует в БД статьи с таким ордером '.$next_order.'(next_order)';
            array_push( $errors, $str );
        };
        if($isError){
            return [
                'ok' => false,
                'errors' => $errors
            ];
        };

        ChangeOrder::make( $current_order, $next_order );

        return [
            'ok' => true,
            'errors' => $errors
        ];

    }

    private function getAlias( $id ){
        $article = $this->find($id);
        return $article->alias;

    }

    public function getEncodedText( $text ){ // получить закодированный
        return htmlentities( $text );

    }

    public function getDecodedText( $text ){ // получить раскодированный
        return html_entity_decode( $text );

    }
   
    public function addNewArticle( $params ){
        AddNewArticle::make( $params );
        
    }

    public function deleteArticle( $alias ){
        DeleteOneArticle::make( $alias );

    }





















}
