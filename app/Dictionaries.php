<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Dictionaries;
use App\Projects;

use Illuminate\Support\Facades\Storage;

use App\Helpers\ModelHelpers\Dictionaries\CheckedParams;
// use App\Helpers\ModelHelpers\Dictionaries\CheckedParams_test; // (test)
use App\Helpers\ModelHelpers\Dictionaries\DeleteQueue;
use App\Helpers\ModelHelpers\Dictionaries\InsertQueue;
use App\Helpers\ModelHelpers\Dictionaries\ReplaceQueue;
use App\Helpers\ModelHelpers\Dictionaries\SetNewParams;
use App\Helpers\ModelHelpers\Dictionaries\InsertToEndQueue;

use App\Helpers\ModelHelpers\Dictionaries\DeleteDictionary;
use App\Helpers\SharedHelpers\ConvertorJSON;


class Dictionaries extends Model
{
    
    protected $table = 'dictionaries';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'status', 'queue', 'projects_id', 'updated_at' ];

    public $timestamps = true;

    public function getListDictionaries(){
        $listModels = $this->all();
        $list = [];
		
        foreach( $listModels as $k ){
			$dic = $this::find( $k->id );
			$sumWords = count( $dic->getWords() );
            $obj = [
                'name' => $k->name,
				'sumWords' => $sumWords,
				'href' => route( 'admin_dictionary', [ 'id' => $k->id ] ),
				'queue' => $k->queue,
				'status' => $k->status
            ];
            array_push($list, $obj);
        };
        return $list;
    }

    public function getWords(){
        /*
            Возвращает массив слов данного проекта у которых есть аудиофайлы
            при этом файлы с повторами тоже возвращаются

            формат данного массива: 
            $arr = [
                "acquaintance" => "знакомый, знакомство",
                "actor" => "художник",
                "airport" => "аэропорт",
                "also" => "тоже",
                ...
            ]

        */
        if( !is_numeric( $this->projects_id ) ){
            // возможная ошибка в применении метода
            return [];
        };

        if( $this->projects_id === 0 ){
            // нет привязанных к данному словарю проектов
            return [];
        };

        $id = $this->projects_id;
        $project = Projects::find( $id );













        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // $words = json_decode( $project->words, true );

        $convertor = new ConvertorJSON();
        $words = $convertor->from_json_to_array( $project->words );




        











        // получаем объект с аудиофайлами
        $puth = env('PUTH_AUDIO_FILES').$id.'/';
        $filesDir = Storage::allFiles( $puth );
        $list_audio_obj = [];
        for( $i = 0; $i < count( $filesDir ); $i++ ){
            $str = $filesDir[ $i ];
            $order   = [ $puth, '.mp3'];
            $newstr = str_replace( $order, '', $str );
            $list_audio_obj[ $newstr ] = $i;
        };

        // получаем объект со словами у которых есть аудиофайл
        $words_with_audio = [];
        foreach( $words as $k => $v ){
            if( isset( $list_audio_obj[ $k ] ) ){
                $words_with_audio[ $k ] = $v;
            };
        };

        return $words_with_audio;
    }

    public function createDictionary( $name ){

        $check_is_name = $this->where('name', '=', $name )->first();

        if( is_null( $check_is_name ) ){
            $newDic = new $this;
            $newDic->name = $name;
            $newDic->projects_id = null;
            $newDic->status = false;
            $newDic->save();
        };

    }
	
	public function getArrListQueue(){
		$dic = new Dictionaries;
		$queues = $dic->where('status','=', '1')->get();
        $arr_q = [];
        foreach( $queues as $obj ){
            array_push( $arr_q, $obj->queue );
        };
        asort($arr_q);
        $arrListQueue = [];
        foreach( $arr_q as $k=>$v ){
            array_push( $arrListQueue, $v );
        };
		return $arrListQueue;
	}
	
	public function getNewLastQueue(){
		$arr_queues = $this->getArrListQueue();
		$nuw_queue = 0;
		for( $i = 0; $i < count( $arr_queues ); $i++ ){
			if( $arr_queues[$i] > $nuw_queue ){
				$nuw_queue = $arr_queues[ $i ];
			};
		};
		$nuw_queue++;
		return $nuw_queue;
    }
    
	public function getLastQueue(){
		$arr_queues = $this->getArrListQueue();
		$nuw_queue = 0;
		for( $i = 0; $i < count( $arr_queues ); $i++ ){
			if( $arr_queues[$i] > $nuw_queue ){
				$nuw_queue = $arr_queues[ $i ];
			};
		};
		return $nuw_queue;
	}
	
    public function setNewQueue( $howToSet, $params = null ){

        // $howToSet - принимает только три варианта ( тип строка )
        //      'replace' - поменять местами ($current_queue с $new_queue)
        //      'insert' - вставить $current_queue на место $new_queue со смещением 
        //      'insertToEnd' - вставить в конец очереди
        //      'deleteQueue' - выкидывает из очереди то что под очередью $current_queue
        //
        // $params должен быть ассоциативным массивом с такими полями 
        //  1 вариант ( для 'insertToEnd' или 'deleteQueue' )
        //     [
        //         (int)'idDictionary' => 1,
        //     ]
        //  2 вариант ( для 'replace' или 'insert' )
        //     [
        //         (int)'idDictionary' => 1,
        //         (int)'currentQueue' => 1,
        //         (int)'nextQueue' => 2,
        //     ]

        $ok = true;
        $errors = '';
        $newQueue = '';

        $checkParams = new CheckedParams( $params );

        if( $howToSet === 'deleteQueue' ){

            if( $checkParams->isValid_from_deleteQueue() ){
                $delete = new DeleteQueue( $params['idDictionary'] );
                $delete->make();
                if( $delete->isFails() ){
                    $ok = false;
                    $errors = $delete->getErrors();
                };
            }else{
                $ok = false;
                $errors = $checkParams->getErrors();
            };

        }else if( $howToSet === 'insertToEnd' ){

            if( $checkParams->isValid_from_insertToEnd() ){
                $insertToEnd = new InsertToEndQueue();
                $res = $insertToEnd->make( $params['idDictionary'] );
                $newQueue = $res['lastQueue'];
                if( $insertToEnd->isFails() ){
                    $ok = false;
                    $errors = $insertToEnd->getErrors();
                };
            }else{
                $ok = false;
                $errors = $checkParams->getErrors();
            };

        }else if( $howToSet === 'insert' ){

            if( $checkParams->isValid_from_insert() ){
                $insert = new InsertQueue();
                $insert->make( $params );
            }else{
                $ok = false;
                $errors = $checkParams->getErrors();
            };
            
        }else if( $howToSet === 'replace' ){

            if( $checkParams->isValid_from_replace() ){
                $replace = new ReplaceQueue();
                $replace->make( $params );
            }else{
                $ok = false;
                $errors = $checkParams->getErrors();
            };

        }/*else if( $howToSet === 'new_action' ){

            дописывать новые действия сюда !!!!!!!!!!!!

        }*/else{
            $ok = false;
            $errors = 'В howToSet передано неизвестное значение, или передано значение с ошибкой в тексте. Ваш howToSet = '.$howToSet;
        };

        return [
            'ok' => $ok,
            'errors' => $errors,
            'newQueue' => $newQueue
        ];
    }

    public function setNewParams( $id, $params ){

        $setParams = new SetNewParams( $id, $params );
        $setParams->make();

        $ok;
        $massage = '';

        if( $setParams->isSaccess() ){
            $ok = true;
        }else{
            $ok = false;
            $massage = $setParams->getErrors();
        };

        return [
            'ok' => $ok,
            'massage' => $massage
        ];

    }

    public function deleteDictionary( $id ){

        $delDict = new DeleteDictionary( $id );
        $delDict->make();

        if( $delDict->isSaccess() ){
            return [
                'ok' => true
            ];
        }else{
            return [
                'ok' => false,
                'errors' => $delDict->getErrors()
            ];
        };

    }

};


























