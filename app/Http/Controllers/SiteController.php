<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use CreateArrFromArticleModel;

use App\User;
use App\Article;
use Storage;
use App\Settings;

use App\Helpers\SharedHelpers\GetUserAccessRights;
use App\Helpers\SharedHelpers\ConvertorJSON;


class SiteController extends Controller
{
    protected $data;
    protected $RN_dictionaries;
    protected $RN_login;

    protected function __construct(){

        $this->RN_dictionaries =    config('settings.routeNames.dictionaries');
        $this->RN_login =           config('settings.routeNames.login');

        $settings = new Settings;
        $keywords =         $settings->get_a_value_for_a_single_setting( 'keywords' );
        $description =      $settings->get_a_value_for_a_single_setting( 'description' );
        $siteTitle =        $settings->get_a_value_for_a_single_setting( 'site_name_part_1' );
        $siteTitleSecond =  $settings->get_a_value_for_a_single_setting( 'site_name_part_2' );

        $this->data = [
            'isAuth' => Auth::check(),
            'showAuthPanel' => true,
            'userName' => $this->getUsName(),
            'articles' => $this->getArticlesArr(), // массив статей согласно ордеру

            'adminPanel' => $this->log_in_to_the_admin_panel(),

            'siteTitle' =>          $siteTitle,
            'siteTitleSecond' =>    $siteTitleSecond,
            'keywords'  =>          $keywords,
            'description' =>        $description,
            
        ];

        $this->add_js_css_files_to_the_data([
            'vendors',
            'main',
            'home',
            'dictionaries',
            'training',
            'registration',
            'reset_password',
            'authorization',
            'information_message',
        ]);


    } 
    
    private function getUsName(){
        if( Auth::check() ){
            $id = Auth::id();
            return User::find( $id )->name;
        }else{
            return '';
        };
    }

    private function getArticlesArr(){
        $article = new Article();
        return CreateArrFromArticleModel::get( $article );
    }




    private function add_js_css_files_to_the_data( $list_of_pages ){
        
       
        for( $i = 0; $i < count( $list_of_pages ); $i++ ){

            $name_of_page = $list_of_pages[ $i ];

            $css =  Storage::disk('assets_css')->allFiles();
            foreach( $css as $item ){
                if( is_numeric( strpos( $item, $name_of_page ) ) ){ 
                    $name = 'css_'.$name_of_page;
                    
                    $this->data[ $name ] = '/assets/css/'.$item;
                    break;
                };
            };

            $js =   Storage::disk('assets_js')->allFiles();
            foreach( $js as $item ){
                if( is_numeric( strpos( $item, $name_of_page ) ) ){ // (!== false) не исправлять, так надо
                    $name = 'js_'.$name_of_page;
                    $this->data[ $name ] = '/assets/js/'.$item;
                    break;
                };
            };

        };

    }


    protected function setJson( $arr ){ 
        // Формирует сообщение, предназначенное для js-файла, которое будет расположено прямо в html, в скрытом div#jsonMassage 
        // в виде json-строки. 
        // Это сообщение являет собой объект с основными параметрами по странице необходимыми для React





        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // $this->data['jsonMassage'] = json_encode( $arr );///, JSON_FORCE_OBJECT

        $convertor = new ConvertorJSON();
        $this->data['jsonMassage'] = $convertor->from_array_to_json( $arr );











    }

    private function log_in_to_the_admin_panel(){

        $res = false;

        if( GetUserAccessRights::isAdmin() ){
            $res = true;
        };

        return $res;
    }


}
