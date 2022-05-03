<?php

namespace App\Helpers\ModelHelpers\Dictionaries\ListDictionaries;

use App\Dictionaries;
use App\Projects;

use Auth;
use App\User;



class GetListDictionariesFromClient {

    static public function make(){

        $levels = new CreateLevels();
        $levelsArr = $levels->make();
        
        return $levelsArr;

        //return GetLevels::make();

    }



};

?>