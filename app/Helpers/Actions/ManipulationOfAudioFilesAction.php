<?php 
namespace App\Helpers\Actions;

use App\Helpers\Contracts\ManipulationOfAudioFiles;

//use App\Projects;
use Illuminate\Support\Facades\Storage;
use Config;

class ManipulationOfAudioFilesAction implements ManipulationOfAudioFiles {

    public static function getList( $id ){
        /*
                ВОЗВРАЩАЕТ МАССИВ ИМЁН АУДИОФАЙЛОВ
                    которые лежат в папке проекта $id

            Каждый элемент массива это строка без '.mp3' и без 'public/audio/'.$id.'/'
            $arr = [
                "acquaintance",
                "actor",
                "airport",
                ...
            ]
        */

        $puth = env('PUTH_AUDIO_FILES').$id.'/';

        $filesDir = Storage::allFiles( $puth );
        $list_audio = [];

        for( $i = 0; $i < count( $filesDir ); $i++ ){
            $str = $filesDir[ $i ];
            $order   = [ $puth, '.mp3'];
            $newstr = str_replace( $order, '', $str );
            array_push( $list_audio, $newstr );
        };
        
		return $list_audio;
    }

    public static function delete( $id, $arr_delete_files ){
        /*
                УДАЛЯЕТ АУДИО ФАЙЛЫ
                
                Должен принять массив $id и $arr_delete_files ($request->delete_files) с именами предназначенных 
            для удаления файлов. В таком виде 
                $arr_delete_files = [
                    'balcony',
                    "actor",
                    "airport",
                    ...
                ];

            Работает только с папкой текущего проекта ($id)
        */

        $puth = env('PUTH_AUDIO_FILES').$id.'/';

        for( $i = 0; $i < count( $arr_delete_files ); $i++ ){
            $name = $arr_delete_files[ $i ].'.mp3';
            Storage::delete( $puth.$name );
        };

    }

    public static function rename( $id, $oldName, $newName ){
        /*
            ПЕРЕИМЕНОВЫВАЕТ ОДИН ФАЙЛ

            Должен принять 
                $oldName = 'balcony'        старое имя
                $newName = 'newbalcony'     новое имя
                
            Строки с именами не должны содержать '.mp3'
        */

        $puth = env('PUTH_AUDIO_FILES').$id.'/';
        
        $OldName = $puth.$oldName.'.mp3';
        $NewName = $puth.$newName.'.mp3';

        $exists = Storage::disk('local')->has( $OldName );

        if( $exists ){
            Storage::move( $OldName, $NewName );
        };

    }
    
    public static function upload( $id, $audioArr ){
        /*
                ЗАГРУЖАЕТ АУДИО ФАЙЛЫ 
            в \en-v6\storage\app\public\audio\{$id}

                Должен принять массив $audioArr из аудио файлов ($request->audio) где каждая отдельная ячейка 
            это отдельный файл (в виде объекта)

            Пропускает только файлы с расширением 'mp3' и размером не больше 40000
            
        */

        $puth = env('PUTH_AUDIO_FILES').$id.'/';

        foreach( $audioArr as $file ){
				
            $size = $file->getSize();
            $extens = $file->getClientOriginalExtension();
				
			if( $extens === 'mp3' ){
				if( $size < 40000 ){
                    $filename = $file->getClientOriginalName(); 
                    
                    $regex_enW = Config::get('my_config.regex.enW');
                    $filename_without_mp3 = str_replace( '.mp3', '',  $filename );

                    $isValidName = preg_match( $regex_enW, $filename_without_mp3 );
                    if( $isValidName ){
                        $destinationPath = 'storage\audio\\'.$id;
                        $file->move( $destinationPath, $filename );
                    };
					//Storage::disk('local')->put( $puth.$filename, $file, 'public' ); // старое, создаёт фальшивые мп3
				};
			};
        };
    }

};

?>