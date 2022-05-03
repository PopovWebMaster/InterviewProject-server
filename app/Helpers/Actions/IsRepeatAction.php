<?php 
namespace App\Helpers\Actions;

//use App\User;
//use Illuminate\Http\Request;
use App\Helpers\Contracts\IsRepeat;
use App\Projects;
use App\Helpers\SharedHelpers\ConvertorJSON;

class IsRepeatAction implements IsRepeat {

    public static function check( $one_word, $id = 0 ){

        $result = [
            'exists' => false,
            'dictionary' => false,
            'project' => false
        ];

        $projects = Projects::all();

        foreach( $projects as $project ){




            // !!!!!!!!!!!!!!!!!!!
            // $words = json_decode( $project->words, true );
            $convertor = new ConvertorJSON();
            $words = $convertor->from_json_to_array( $project->words );





            $isBreack = false;

           
            
            if( $project->id !== (int)$id ){
                if( count($words) !== 0 ){
                    foreach( $words as $enW => $ruW ){
                        if( $enW === $one_word ){
                            $result = [
                                'exists' => true,
                                'dictionary' => false,
                                'project' => $project->name,
                                'enW' => $enW,
                                'ruW' => $ruW
                            ];
                            $isBreack = true;
                            break;
                        };
                    };
                };
                if( $isBreack ){
                    break;
                };
            };
        };
        return $result;
    }

};

?>