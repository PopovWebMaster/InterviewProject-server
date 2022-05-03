<?php

namespace App\Helpers\ModelHelpers\Dictionaries;
use App\Dictionaries;
use App\Projects;

class InsertQueue {

    public function make( $params ){

        $id = $params['idDictionary'];
        $current_queue = $params['currentQueue'];
        $next_queue = $params['nextQueue'];

        $dictionaries = new Dictionaries();

        $current_dic = $dictionaries->where('queue', '=', $current_queue )->first();
        $next_dic = $dictionaries->where('queue', '=', $next_queue )->first();


        $arr = [];
        foreach( $dictionaries->get() as $item ){
            if( !is_null( $item->queue ) ){
                $arr[ $item->queue ] = $item->id;
            };
        };
        ksort($arr);

        $arr_result;

        if( (int)$next_queue === (int)$current_queue ){
            $arr_result = $arr;
        }else{
            $arr_2 = [];
            $new_queue = 1;
            foreach( $arr as $key => $value ){
                if( (int)$key !== (int)$current_queue ){
                    if( (int)$key === (int)$next_queue ){
                        if( (int)$next_queue < (int)$current_queue ){
                            
                            $arr_2[ $new_queue ] = $current_dic->id;
                            $new_queue++;
                            $arr_2[ $new_queue ] = $value;

                        }else if( (int)$next_queue > (int)$current_queue ){

                            $arr_2[ $new_queue ] = $value;
                            $new_queue++;
                            $arr_2[ $new_queue ] = $current_dic->id;

                        }/*else{
                            Когда ( (int)$next_queue === (int)$current_queue ) делать ничего не нужно
                        }*/;
                    }else{
                        $arr_2[ $new_queue ] = $value;
                    };
                    $new_queue++;
                };
            };

            $arr_result = $arr_2;

        };

        foreach( $arr_result as $key => $value ){
            $dic = $dictionaries->find( $value );
            $dic->queue = $key;
            $dic->save();
        };
    }

};


?>