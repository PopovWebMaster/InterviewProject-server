<?php

namespace App\Helpers\ModelHelpers\Dictionaries;
use App\Dictionaries;
use App\Projects;

class DeleteDictionary {
    
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

        $res = $dictionaries->setNewQueue( 'deleteQueue', [ 'idDictionary' => $this->id ] );

        if( $res['ok'] ){

            $dic = $dictionaries->find( $this->id );

            if( is_null( $dic ) ){
                $str = 'В БД нет словаря с таким id - '.$this->id.' .Нечего удалять';
                $this->setError( $str );

            }else{
                $dic->delete();
            };

        }else{
            $str = $res['errors'];
            $this->setError( $str );
        }; 
    }

    public function isSaccess(){
        return !$this->isError;
    }

    public function getErrors(){
        return $this->errors;
    }


};


?>