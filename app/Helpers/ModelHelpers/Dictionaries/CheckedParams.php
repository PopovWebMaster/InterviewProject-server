<?php

namespace App\Helpers\ModelHelpers\Dictionaries;
use App\Dictionaries;
use App\Projects;

class CheckedParams {

    // Проверяет массив параметров, который должен иметь следующий вид
    // [
    //     'idDictionary' => (int)1,
    //     'currentQueue' => (int)2,
    //     'nextQueue' => (int)3,
    // ]

    protected $id_name =            'idDictionary';
    protected $currentQueue_name =  'currentQueue';
    protected $nextQueue_name =     'nextQueue';

    protected $errors = [];
    protected $isError = false;
    protected $params;

    function __construct( $params ){
        $this->params = $params;

        $this->performs_a_check(); // выполняет проверку

    }

    protected function setError( $str ){
        array_push( $this->errors, $str );
        $this->isError = true;
    }

    protected function performs_a_check(){
        
        /* Первичная проверка */
        if( is_null( $this->params ) ){
            $str = 'Не переданы параметры';
            $this->setError( $str );
        }else if( !is_array( $this->params ) ){
            $str = 'Параметры должны быть массивом, а они имеют тип '.gettype( $this->params );
            $this->setError( $str );
        };
        if( $this->isError ){
            return ;
        };

        /* Проверка необходимых элементов массива */
        $main_field =  isset( $this->params[$this->id_name] );
        if( $main_field ){ 
            /* (начало) Здесь проверка главного поля id, которое должно быть всегда */
            $id = (int)$this->params[ $this->id_name ]; 
            $dictionaries = new Dictionaries();
            $dictionary = $dictionaries->find( $id ); 

            if( is_null( $dictionary ) ){
                $str = 'Словарь с id = '.$this->params[ $this->id_name ].' ('.gettype( $this->params[ $this->id_name ] ).') отсутствует в БД';
                $this->setError( $str ); 
            /* (конец) проверка поля id*/
            }else{

                /* (Начало) Проверка дополнительных полей */

                $isset_field_1 = isset( $this->params[$this->currentQueue_name] );
                $isset_field_2 = isset( $this->params[$this->nextQueue_name] );

                if( !$isset_field_1 && !$isset_field_2 ){
                    /*
                        Ошибки нет, вариант при котором эти поля одновременно оба не нужны
                    */
                    return ;
                }else{

                    /* прверяем $this->currentQueue_name */
                    if( isset( $this->params[ $this->currentQueue_name ] ) ){ 
                        if( is_int( $this->params[ $this->currentQueue_name ] ) ){
                            if( is_null( $dictionary->queue ) ){
                                $str = 'Поле queue в БД содержит null, а этого быть не должно, так как мы в нём ожидаем - '.$this->params[ $this->currentQueue_name ];
                                $this->setError( $str );
                            }else{
                                if( (int)$dictionary->queue !== (int)$this->params[ $this->currentQueue_name ] ){
                                    $str = 'Поле '.$this->currentQueue_name.' содержит значение отличное от значения queue данного словаря в БД, а они должны быть одинаковыми';
                                    $this->setError( $str );
                                }/*else{
                                    Здесь новые правила проверки $this->currentQueue_name,
                                    если таковые потребуются, то !!!!!!!!!!!! ДОПИСЫВАТЬ СЮДА !!!!!!!!!!!!!!
                                }*/;  
                                
                            };
                        }else{
                            $str = 'Поле '.$this->currentQueue_name.' не является целочисленным значением - '/*.$this->params[ $this->currentQueue_name ]*/;
                            $this->setError( $str );
                        };
                    }else{
                        $str = 'Отсутствует поле '.$this->currentQueue_name;
                        $this->setError( $str );
                    };

                    /* прверяем $this->nextQueue_name */
                    if( isset( $this->params[ $this->nextQueue_name ] ) ){
                        if( is_int( $this->params[ $this->nextQueue_name ] ) ){
                            $issetNextQueue = $dictionary->where( 'queue', '=', (int)$this->params[ $this->nextQueue_name ] )->first();
                            if( is_null( $issetNextQueue ) ){
                                $str = 'Поле '.$this->nextQueue_name.' имеет некорректное значение, в списке возможных значений queue в БД нет такого, которое соответствовало бы - '.$this->params['nextQueue'].' ('.gettype( $this->params[ $this->id_name ] ).')';
                                $this->setError( $str );
                            }/*else{
                                Здесь новые правила проверки $this->nextQueue_name,
                                если таковые потребуются, то !!!!!!!!!!!! ДОПИСЫВАТЬ СЮДА !!!!!!!!!!!!!!
                            }*/;  
                        }else{
                            $str = 'Поле '.$this->nextQueue_name.' не является целочисленным значением - '.$this->params[ $this->nextQueue_name ];
                            $this->setError( $str );
                        };
                    }else{
                        $str = 'Отсутствует поле '.$this->nextQueue_name;
                        $this->setError( $str );
                    };

                };

                /*
                    Проверку дополнительных полей !!!!!!!!!!!! ДОПИСЫВАТЬ СЮДА !!!!!!!!!!!!!!
                */


                /* (конец) Проверка дополнительных полей */
            };
        }else{
            $str = 'Отсутствует поле '.$this->id_name ;
            $this->setError( $str );
        };

    }

    public function isValidParams(){
        return !$this->isError;
    }

    public function isValid_from_deleteQueue(){
        return !$this->isError;
    }

    public function isValid_from_insertToEnd(){
        return !$this->isError;
    }

    public function isValid_from_insert(){
        if( $this->isError ){
            return false;
        }else{
            $field_1 = isset( $this->params[$this->id_name] );
            $field_2 = isset( $this->params[$this->currentQueue_name] );
            $field_3 = isset( $this->params[$this->nextQueue_name] );

            if( $field_1 && $field_2 && $field_3 ){
                return true;
            }else{
                return false;
            };
        };
    }

    public function isValid_from_replace(){

        if( $this->isError ){
            return false;
        }else{
            $field_1 = isset( $this->params[$this->id_name] );
            $field_2 = isset( $this->params[$this->currentQueue_name] );
            $field_3 = isset( $this->params[$this->nextQueue_name] );
            
            if( $field_1 && $field_2 && $field_3 ){
                return true;
            }else{
                return false;
            };
        };
    }

    public function getErrors(){
        return $this->errors;
    }





};




?>