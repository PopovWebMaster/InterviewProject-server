<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Projects;

use Validator;
use Config;
use AudioFiles;

class AudioController extends SiteAdminController
{
    public function __construct(){
        parent::__construct();
        
    }
	
    public function post( Request $request, $id ){

        $regex_enW = Config::get('my_config.regex.enW');
        $rules = [
            'action' => 'required|string|alpha_num|in:upload,delete,rename',
            'id' => 'required|integer|digits_between:1,6|min:1',
            'audio' => 'sometimes|array',
            'audio.*' => 'file',
            'delete_files' => 'sometimes|array',
            'delete_files.*' => 'string|regex:'.$regex_enW,
            'oldName' => 'sometimes|required_with:newName|string|regex:'.$regex_enW,
            'newName' => 'sometimes|required_with:oldName|string|regex:'.$regex_enW,
            
        ];

        $checkArray = $request->all();
        $checkArray['id'] = (int)$id;
        
        $validator = Validator::make( $checkArray, $rules );
        $respons_failed = [
            'ok' => false,
            'massage' => $validator->getMessageBag()->all()
        ];
        if( $validator->fails() ){
            return $respons_failed;
        };

        $PROJECT = new Projects;
        $project = $PROJECT->find( $id );

        if( is_null( $project ) ){
            return redirect()->route('admin_projects');
        };

        $action = $request->action;

        $res;


        if( $action === 'upload' ){
            /*
                    ЗАГРУЖАЕТ АУДИО ФАЙЛЫ по адресу env('PUTH_AUDIO_FILES').{$id}
                Должен принять массив $request->audio где каждая отдельная ячейка 
                это отдельный файл (в виде объекта
                Пропускает только файлы с расширением 'mp3' и размером не больше 40000
            */
            if( isset( $request->audio ) ){
                AudioFiles::upload( $id, $request->audio );
                $res = $this->getResponseSuccess( $id );
                //return $this->getResponseSuccess( $id );
            }else{
                $res = $respons_failed;
                //return $respons_failed;
            };

        }else if( $action === 'delete' ){
            /*
                    УДАЛЯЕТ АУДИО ФАЙЛЫ
                Должен принять массив $request->delete_files с именами предназначенных для удаление файлами 
                Эти имена должны быть строками без .mp3
                Пример:
                    $request->delete_files = [ 'balcony', ... ] (правильно)
                    $request->delete_files = [ 'balcony.mp3', ... ] (не правильно)  
                Удаляет только из папки текущего проекта. Ориентируется по $id
            */
            if( isset( $request->delete_files ) ){

                AudioFiles::delete( $id, $request->delete_files );
                $res = $this->getResponseSuccess( $id );
                //return $this->getResponseSuccess( $id );
            }else{
                $res = $respons_failed;
                //return $respons_failed;
            };

        }else if( $action === 'rename' ){
            /*
                    ПЕРЕИМЕНОВЫВАЕТ ОДИН ФАЙЛ
                Должен принять
                $request->oldName - старое имя (например 'balcony')
                $request->newName - новое имя (например 'newbalcony')
                Строки с именами не должны содержать '.mp3'
            */

            if( isset( $request->oldName ) && isset( $request->newName ) ){
                AudioFiles::rename( $id, $request->oldName, $request->newName );
                $res = $this->getResponseSuccess( $id );
                //return  $this->getResponseSuccess( $id );
            }else{
                $res = $respons_failed;
                //return $respons_failed;
            };

        };

        $PROJECT->setCountValidWords( $id );
        
        return $res;

    }

    private function getResponseSuccess( $id ){
        // Вызывать только в местах, где уже провалидорован $id
        $PROJECT = new Projects;
        $project = $PROJECT->find( $id );

        return [
            'ok' => true,
            'words' => $PROJECT->getListWordsFromClient( $id ), 
            'audioList' => AudioFiles::getList( $id ),
        ];
    }
}




