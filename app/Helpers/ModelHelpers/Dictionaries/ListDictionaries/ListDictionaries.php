<?php

namespace App\Helpers\ModelHelpers\Dictionaries\ListDictionaries;

use App\Dictionaries;
use App\Projects;

use Auth;
use App\User;

class ListDictionaries {

    static public function make(){

        $dictionaries = new Dictionaries();
        $dicArr = $dictionaries->get();
        $newArr = [];
        $projects = new Projects();
        foreach( $dicArr as $item ){
            if( $item->status ){

                $project = $projects->find($item->projects_id);

                $newArr[ $item->queue ] = [
                    'dictionary_id' => $item->id,
                    'sum_words_in_dictionary' => $project->count_valid_words,
                    'queue' => $item->queue,
                ];
            };
        };
        
        ksort($newArr);

        return $newArr;
    }

};