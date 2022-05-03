<?php

namespace App\Helpers\ModelHelpers\Dictionaries;
use App\Dictionaries;
use App\Projects;

class ReplaceQueue {

    public function make( $params ){
        
        $current_queue = $params['currentQueue'];
        $next_queue = $params['nextQueue'];
        
        $dictionaries = new Dictionaries();

        $current_dic = $dictionaries->where( 'queue', '=', $current_queue )->first();
        $next_dic = $dictionaries->where( 'queue', '=', $next_queue )->first();

        $current_dic->queue = $next_queue;
        $current_dic->save();

        $next_dic->queue = $current_queue;
        $next_dic->save();
    }


};


?>