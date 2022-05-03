<?php

namespace App\Helpers\ModelHelpers\Dictionaries;
use App\Dictionaries;
use App\Projects;

use App\Helpers\ModelHelpers\Dictionaries\CheckedParams;

class CheckedParams_test {

    static public function start(){

        // без параметров
        $checkClass = new CheckedParams('');
        echo    '<pre>                           - 1 -
                без параметров (Ошибка)
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            'idDictionary' => '2',
            'currentQueue' => '3',
            'nextQueue' => '5',
        ]);
        echo    '<pre>                           - 2 -
                все параметры строки (Ошибка)
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';
        
        $checkClass = new CheckedParams([
            'idDictionary' => 11111, 
            //'currentQueue' => '3',
            //'nextQueue' => '5',
        ]);
        echo   '<pre>                            - 3 -
                id - число, не существует такого в БД  (Ошибка)
                currentQueue - поле отсутствует (Ошибка)
                nextQueue - поле отсутствует (Ошибка)
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            //'idDictionary' => 11111, 
            'currentQueue' => 4,
            'nextQueue' => 3,
        ]);
        echo   '<pre>                            - 4 -
                id - поле отсутствует  (Ошибка)
                currentQueue - правильный
                nextQueue - правильный
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => 4,
            'nextQueue' => 333,
        ]);
        echo    '<pre>                            - 5 -
                id - число, существует в БД 
                currentQueue - число, совпадает
                nextQueue - число, таких в списке БД нет (Ошибка)
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => 5,
            'nextQueue' => '3',
        ]);
        echo    '<pre>                            - 6 -
                id - число, существует в БД 
                currentQueue - число, не правильный не совпадает со значением в БД (Ошибка)
                nextQueue - строка   (Ошибка)
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';
        
        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => 55,
            'nextQueue' => 3,
        ]);
        echo    '<pre>                            - 7 -
                id - число, существует в БД 
                currentQueue - число, но нет таких в списке БД  (Ошибка)
                nextQueue - существующий  
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';
        
        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => '55we',
            'nextQueue' => 3,
        ]);
        echo    '<pre>                            - 8 -
                id - число, существует в БД  
                currentQueue - строка (Ошибка)
                nextQueue - число, существующий  
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => 5,
            'nextQueue' => 3333,
        ]);
        echo    '<pre>                            - 9 -
                id - число, существует в БД 
                currentQueue - число, не правильный не совпадает с значением в БД (Ошибка)
                nextQueue - число, НЕ существует в списке БД  (Ошибка)
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => 5,
            'nextQueue' => '3333wqwqw',
        ]);
        echo    '<pre>                            - 10 -
                id - число, существует в БД
                currentQueue - число, не правильный в БД таких нет (Ошибка)
                nextQueue - строка   (Ошибка)
                </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => 4,
            'nextQueue' => 4,
        ]);
        echo    '<pre>                            - 11 -
                id - число, существует в БД
                currentQueue  и nextQueue правильные, но одинаковые  (Ошибка) </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';

        $checkClass = new CheckedParams([
            'idDictionary' => 5, 
            'currentQueue' => 4,
            'nextQueue' => 4,
        ]);
        echo    '<pre>                            - 12 -
                всё правильно  </pre>';
        dump( $checkClass->isValidParams() );
        dump( $checkClass->getErrors() );
        echo '---------------------------------------------------------------------- <br>';




        dd('Конец');


    }

};




?>