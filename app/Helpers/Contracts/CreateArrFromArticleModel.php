<?php 

/*
    Задача данного контракта вернуть правильно сформированный массив из статей с названиями и псевданимами. 
    Принимает модель Article а возвращает массив по возрастанию статей согласно ордеру
*/
namespace App\Helpers\Contracts;

Interface CreateArrFromArticleModel {
    public static function get();
}

?>