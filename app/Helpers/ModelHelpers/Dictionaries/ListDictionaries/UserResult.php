<?php

namespace App\Helpers\ModelHelpers\Dictionaries\ListDictionaries;

use App\Dictionaries;
use App\Projects;

use Auth;
use App\User;
use App\Results;
use App\Helpers\SharedHelpers\ConvertorJSON;




class UserResult {

    protected $user;
    protected $userId;
    protected $userResult;

    public function __construct(){
        //     Всегда берёт данные авторизированного пользователя
        // Этот class не предназначен к использованию не авторизированным пользователем

        $auth = Auth::user();
        $id = $auth->id;
        $this->userId = $id;
        $users = new User();
        $this->user = $users->find( $id );
        $this->userResult = $this->user->result;

    }

    private function from_json_to_array( $str ){
        //return json_decode( $str, true );

        $convertor = new ConvertorJSON();
        $arr = $convertor->from_json_to_array( $str );

        return $arr;

    }

    private function from_array_to_json( $arr ){

        //return json_encode( $arr );

        $convertor = new ConvertorJSON();
        $json = $convertor->from_array_to_json( $arr );
        return $json;


        





    }

    public function get(){
        //     Если у пользователя есть запись в БД с результатами, то возвращает массив с этими результатами,
        // а если записи в БД нет то вернёт null
        //     Возвращаемый массив имеет следующую структуру:
        // [  
        //     1 => 111,
        //     2 => 222,
        //     ...
        // ]
        // где     ключ - id словаря (по которому пользователь проходил тестирование)
        //     значение - сумма слов, которые пользователь указал по тесту правильно (выучил)

        if( !is_null($this->userResult) ){
            $resJson = $this->userResult->result;

            return $this->from_json_to_array( $resJson );
        }else{
            return null;
        };

    }

    public function set( $params ){
       
        $user_id =          $params['user_id'];
        $dictionary_id =    $params['dictionary_id'];
        $new_result =       $params['new_result'];

        $ok;
        $errors = [];

        $newArr = [];
        $errorText = 'Ошибка, отсутствует право сделать запись результата для данного пользователя';

        $permission_to_record = $this->check_the_right_to_record_the_result( $dictionary_id );

        if( $permission_to_record ){
            $ok = true;

            if( !is_null( $this->userResult ) ){ // запись result в БД есть
                $oldArr = $this->get();

                foreach( $oldArr as $k => $v){
                    $newArr[$k] = $v;
                };

                $newArr[ $dictionary_id ] = $new_result;

                $jsonArr = $this->from_array_to_json( $newArr );
                $this->userResult->result = $jsonArr;
                $this->userResult->save();

            }else{ // записи в БД нет

                $newArr[ $dictionary_id ] = $new_result;
                $jsonArr = $this->from_array_to_json( $newArr );

                $results = new Results();
                $results->user_id =  $user_id;
                $results->result =   $jsonArr;
                $results->save();

            };

        }else{
            $ok = false;
            array_push( $errors, $errorText );
        };

        return [
            'ok' => $ok,
            'errors' => $errors
        ];

    }

    private function check_the_right_to_record_the_result( $dictionary_id ){

        $Levels = new CreateLevels();
        $levels = $Levels->make();

        $result = false;
        $dictionary = Dictionaries::find( $dictionary_id );

        if( !is_null( $dictionary ) ){
            $queue = $dictionary->queue;

            foreach( $levels as $k => $v ){
                if( isset($levels[$k][$queue]  )  ){
                    $result = true;
                    break;
                };
            };

        };

        return $result;

    }





};

?>