<?php

namespace App\Helpers\ModelHelpers\Dictionaries;
use App\Dictionaries;
use App\Projects;

class DeleteQueue {
    
    protected $isError = false;
    protected $errors = [];
    protected $id = [];

    function __construct( $id ){
        $this->id = $id;
    }

    private function setError( $str ){
        array_push( $this->errors, $str );
        $this->isError = true;
    }

    public function make(){

        $dictionaries = new Dictionaries();
        $dictionary = $dictionaries->find( $this->id );
        $dictionary->queue = null;
        $dictionary->save();

        $dictionaries = new Dictionaries();

        $arr = [];
        foreach( $dictionaries->get() as $item ){
            if( !is_null( $item->queue ) ){
                $arr[ $item->queue ] = $item->id;
            };
        };

        ksort( $arr );

        $arr_2 = [];
        $queueCount = 1;
        foreach( $arr as $k => $v ){
            $arr_2[ $queueCount ] = $v;
            $queueCount++;
        };

        foreach( $arr_2 as $k => $v ){
            
            $dic = $dictionaries->find( $v );
            $dic->queue = $k;
            $dic->save();
        };
        
        
    }

    public function isFails(){
        return $this->isError;
    }

    public function getErrors(){
        return $this->errors;
    }


};


?>