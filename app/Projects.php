<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use IsRepeat;
use IsAudio;
use AudioFiles;

use App\Dictionaries;

use App\Helpers\ModelHelpers\Projects\ListProjects;
use App\Helpers\SharedHelpers\ConvertorJSON;


class Projects extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'description', 'words', 'author', 'status' ];

    public $timestamps = true;


    public function setNewProject( $name, $author ){
        $project = $this;
        $project->name = $name;
        $project->description = '';
        $project->words = '';
        $project->author = $author;
        $project->status = 0;
        $project->save();
    }

    public function getListProjects(){
        $listProjects = ListProjects::get();
        return $listProjects;

    }

    public function deleteProject( $id = null ){
        if( is_null($id) ){
            return;
        };
        $id_project = (int)$id;

        $dic = new Dictionaries;
        $dictionary = $dic->where('projects_id','=', $id_project )->first();
        
        if( !is_null($dictionary) ){
            $id_dictionary = $dictionary->id;
            $params = [
                'name' => $dictionary->name,
                'status' => 'false',
                'queue' => '',
                'projectId' => ''
            ];
            $res = $dic->setNewParams( $id_dictionary, $params );
        };
        $res = $this::find( $id_project);
        $res->delete();
    }

    public function getListWordsFromClient( $id ){
        /*
            Возвращает готовый для отправки клиенту массив слов взятый из БД

        */
        
        $project = $this->find( $id );

        if( $project === null ){
            return 'Ошибка в getListWordsFromClient';
        };

        







        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //$words = json_decode( $project->words, true );
        $convertor = new ConvertorJSON();
        $words = $convertor->from_json_to_array( $project->words );
        












        $respArr = [];
		
		if( !is_null($words)){
			foreach( $words as $enW => $ruW ){
				$obj = [
					'enW' => $enW,
					'ruW' => $ruW,
					'isRepeat' => IsRepeat::check( $enW, $id ),
					'isAudio' => IsAudio::check(  $id, $enW )
				];
				$respArr[] = $obj;

			};
		};
        return $respArr;
    }


    public function getListWordsFromDictionary( $id ){
        /*
            Возвращает массив слов (массив объектов) предназначенный для использования в словаре, 
            в том числе при выводе слов клиенту
            Возвращает список только тех слов которые имеют соответствующий аудио файл

        */
		if( is_null($id) ){
			return [];
		};

        $words = $this->getListWordsFromClient( $id );

        $arrW = [];
		
        foreach( $words as $obj ){
            $aa = $obj['isAudio'];
            $isAudio = $aa['exists'];

            if( $isAudio ){
                $objRes = [
                    'enW' => $obj['enW'],
					'ruW' => $obj['ruW'],
                ];
                array_push( $arrW, $objRes );
            };
        };
        return $arrW;
    }

    public function setNewWords( $id, $arr ){
        /*
            Дописывает новые слова к старому списку
            Возвращает готовый для отправки клиенту массив обновлённых слов (старые  + новые)

            Пример $arr = [ 
                ["enW" => "words","ruW" => "слова"],
                ["enW" => "decent", "ruW" => "приичный"]
            ];
        */

        $project = $this->find( $id );

        if( $project === null ){
            return 'Ошибка в setNewWords';
        };



        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //$old_words = json_decode( $project->words, true );
        $convertor = new ConvertorJSON();
        $old_words = $convertor->from_json_to_array( $project->words );















		if( is_null($old_words)){
			$old_words = [];
		};

        $new_words = [];
        for( $i = 0; $i < count( $arr ); $i++ ){
            $enW = $arr[$i]["enW"];
            $ruW = $arr[$i]["ruW"];
            $new_words[ $enW ] = $ruW;
        };

        $words_for_db = [];
        $words_for_db = array_merge( $old_words, $new_words );










        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //$words_for_db_json = json_encode( $words_for_db );
        $convertor = new ConvertorJSON();
        $words_for_db_json = $convertor->from_array_to_json( $words_for_db );

















        $project->words = $words_for_db_json;
        $project->save();

        $this->setCountValidWords( $id );
        
        return $this->getListWordsFromClient( $id );
    }

    public function updateWords( $id, $arr ){
        /*
            Перезаписывает список слов в БД. Берёт нвый список и меняет его на старый
            Возвращает готовый для отправки клиенту массив обновлённых слов
            $proj = new Projects;
            $arrW = [ 
                [ "enW" => "one", "ruW" => "один" ], 
                [ "enW" => "first", "ruW" => "первый" ],
                [ "enW" => "words", "ruW" => "слова"],
                [ "enW" => "decent","ruW" => "приличный приприличный" ],
                [ "enW" => "indecent","ruW" => "непорядочный" ],
                [ "enW" => "honest","ruW" => "честный, справедливый" ]
            ];
            dump( $proj->updateWords( $id, $arrW ) );
        
        */
        $project = $this->find( $id );

        if( $project === null ){
            return 'Ошибка в updateWords';
        };

        $new_list_words = [];
        for( $i = 0; $i < count( $arr ); $i++ ){
            $enW = $arr[$i]["enW"];
            $ruW = $arr[$i]["ruW"];
            $new_list_words[ $enW ] = $ruW;
        };






        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //$words_for_db_json = json_encode( $new_list_words );
        $convertor = new ConvertorJSON();
        $words_for_db_json = $convertor->from_array_to_json( $new_list_words );



















        $project->words = $words_for_db_json;
        $project->save();

        $this->setCountValidWords( $id );
        
        return $this->getListWordsFromClient( $id );

    }

    public function deleteWords( $id, $arr ){
        /*
            Удаляет слова из БД согласно списку в $arr
            Возвращает готовый для отправки клиенту массив обновлённых слов

            $res = $proj->deleteWords( $id, [
                ["enW" => "one","ruW" => "один"],
                ["enW" => "decent", "ruW" => "приичный"]
            ]);
            dump( $res );
        */
        
        $project = $this->find( $id );

        if( $project === null ){
            return 'Ошибка в deleteWords';
        };

        for( $i = 0; $i < count( $arr ); $i++){
            $enW = $arr[$i]["enW"];
            $ruW = $arr[$i]["ruW"];
            $delete_list[ $enW ] = $ruW;
        };



        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //$words = json_decode( $project->words, true );
        $convertor = new ConvertorJSON();
        $words = $convertor->from_json_to_array( $project->words );















		
		if( is_null($words)){
			return $this->getListWordsFromClient( $id );
		};
        
        $new_list = [];
        foreach( $words as $enW => $ruW ){
            if( !isset($delete_list[ $enW ]) ){
                $new_list[ $enW ] = $ruW;
            };
        };






        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //$words_for_db_json = json_encode( $new_list );
        $convertor = new ConvertorJSON();
        $words_for_db_json = $convertor->from_array_to_json( $new_list );















        $project->words = $words_for_db_json;
        $project->save();

        AudioFiles::delete( $id, [ $arr[0]['enW'] ] );

        $this->setCountValidWords( $id );

        return $this->getListWordsFromClient( $id );
    }

    public function setCountValidWords( $id ){ // не забыть поменять на private

        // Валидными считает только те слова у которых есть аудио файл
        // слова с повторами также входят в число валидных

        $words = $this->getListWordsFromClient( $id );

        $countValidWords = 0;
        foreach( $words as $item ){
            if( $item["isAudio"]["exists"] ){
                $countValidWords++;
            };
        };

        $projects = new $this;

        $project = $projects->find( $id );
        $project->count_valid_words = $countValidWords;
        $project->save();

    }

























}
