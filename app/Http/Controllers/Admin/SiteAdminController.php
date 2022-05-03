<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Settings;

use Storage;
use App\Helpers\SharedHelpers\ConvertorJSON;

class SiteAdminController extends Controller
{
    protected $data;
    
    protected function __construct(){
        $settings = new Settings();
        $settings_values = $settings->getListSettingsForClient();
        
        $this->data = [
            'isAuth' => Auth::check(),
            'userName' => $this->getUsName(),
            'siteTitle' => $settings_values['site_name_part_1']['value'],
            'siteTitleSecond' => $settings_values['site_name_part_2']['value'],
            'keywords'  => '',
            'description' => '',
            'css_file' => '/assets/admin/css/'.$this->get_href_of_css(),
            'vendors_js' => '/assets/admin/js/'.$this->get_script_vendors_js(),
            'app_js' => '/assets/admin/js/'.$this->get_script_app_js(),
        ];
    }

    private function getUsName(){
        if( Auth::check() ){
            $id = Auth::id();
            return User::find( $id )->name;
        }else{
            return '';
        };
    }

    private function get_href_of_css(){
        // Возвращает имя css файла с последним актуальным hash-кодом
        $link_css = Storage::disk('assets_admin_css')->allFiles()[0];
        return $link_css;
    }

    private function get_script_vendors_js(){
        // Возвращает имя js файла с последним актуальным hash-кодом
        $js = Storage::disk('assets_admin_js')->allFiles();
        $vendors_js = '';
        foreach( $js as $item ){
            if( strpos( $item, 'vendors') !== false ){
                $vendors_js = $item;
            };
        };
        return $vendors_js;
    }

    private function get_script_app_js(){
        // Возвращает имя js файла с последним актуальным hash-кодом
        $js = Storage::disk('assets_admin_js')->allFiles();
        $app_js = '';
        foreach( $js as $item ){
            if( strpos( $item, 'app') !== false ){
                $app_js = $item;
            };
        };
        return $app_js;
    }

    protected function setJson( $arr ){ 
        // Формирует сообщение, предназначенное для js-файла, которое будет расположено прямо в html, в скрытом div#jsonMassage 
        // в виде json-строки. 
        // Это сообщение являет собой объект с основными параметрами по странице необходимыми для React




        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // $this->data['jsonMassage'] = json_encode( $arr );///, JSON_FORCE_OBJECT

        $convertor = new ConvertorJSON();
        $this->data['jsonMassage'] = $convertor->from_array_to_json( $arr );


    }

}
