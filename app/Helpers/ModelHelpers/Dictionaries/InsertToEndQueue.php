<?php 

namespace App\Helpers\ModelHelpers\Dictionaries;
use App\Dictionaries;
use App\Projects;

class InsertToEndQueue {

    protected $isError = false;
    protected $errors = [];

    private function setError( $str ){
        array_push( $this->errors, $str );
        $this->isError = true;
    }

    public function make( $id ){

        $dictionaries = new Dictionaries();
        $max_queue = 0;
        $last_queue = null;
        $current_dic = $dictionaries->find( $id );
        if( !is_null( $current_dic->queue ) ){

            $current_queue = $current_dic->queue;
            $current_id = $current_dic->id;

            $arr = [];
            foreach( $dictionaries->get() as $item ){
                if( !is_null($item->queue) ){
                    if( $item->queue !== $current_queue ){
                        $arr[$item->queue] = $item->id;
                    };
                };
            };

            ksort($arr);

            $arr_2 = [];
            $q = 1;
            foreach( $arr as $k => $v ){
                $arr_2[$q] = $v;
                $q++;
            };
            $arr_2[$q] = $current_id;
            foreach( $arr_2 as $k => $v ){
                $dic = $dictionaries->find( $v );
                $dic->queue = $k;
                $dic->save();
            };





            // $str = 'Нельзя вставить в конец очереди словарь, у которого уже прописана очередь (queue в БД) отличная от null';
            // $this->setError( $str );
        }else{
            foreach( $dictionaries->get() as $item ){
                if( !is_null($item->queue) ){
                    if( (int)$item->queue > $max_queue ){
                        $max_queue = (int)$item->queue;
                    };
                };
            };
            $last_queue = $max_queue + 1;
            $current_dic->queue = $last_queue;
            $current_dic->save();
        };
        return [
            'lastQueue' => $last_queue,
        ];
    }
    public function isFails(){
        return $this->isError;
    }
    public function getErrors(){
        return $this->errors;
    }

    
};


?>