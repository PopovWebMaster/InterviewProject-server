<?php 
namespace App\Helpers\Actions;

//use App\User;
//use Illuminate\Http\Request;
use App\Helpers\Contracts\IsAudio;

//use AudioFiles;
use Illuminate\Support\Facades\Storage;

class IsAudioAction implements IsAudio {

    public static function check(  $id, $one_word ){

        $puth = env('PUTH_AUDIO_FILES').$id.'/';
        
        $name = $puth.$one_word.'.mp3';

        $exists = Storage::disk('local')->has( $name );

        return [
            'exists' => $exists,
        ];
    }

};

?>