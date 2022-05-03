<?php

namespace App\Helpers\ModelHelpers\Dictionaries\ListDictionaries;

use App\Dictionaries;
use App\Projects;
use App\Settings;

use Auth;
use App\User;

use App\Helpers\SharedHelpers\GetMinSumWordsInOneLevel;

class CreateLevels {

    private $settings;

    public function __construct(){

        $this->settings = new Settings();

    }

    public function make(){

        $userResult = $this->get_userResult();

        $sum_dictionaries_in_one_level =  $this->get_sum_dictionaries_in_one_level();
        $scale_stars_for_one_dictionary =  $this->get_scale_stars_for_one_dictionary();

        $listDictionaries = ListDictionaries::make();

        // получаем массив с уровнями
        $levels = [];
        $countLevels = 1;
        $oneLevel = [];
        $countDicInOneLevel = 0;
        $sum_words_in_one_level = 0;
        $user_result_in_one_level = 0;
        foreach( $listDictionaries as $queue => $item ){
           
            $user_result;
            if( isset( $userResult[ $item['dictionary_id'] ] ) ){
                $user_result = $userResult[ $item['dictionary_id'] ];
            }else{
                $user_result = 0;
            };

            if( $countDicInOneLevel < $sum_dictionaries_in_one_level ){

                $oneLevel[$queue] = [
                    'dictionary_id' => $item['dictionary_id'],
                    'sum_words_in_dictionary' => $item['sum_words_in_dictionary'],
                    'user_result' => $user_result,
                    'href' => route( 'training', [ 'queue' => $item['queue'] ] ),
                ];

                $sum_words_in_one_level = $sum_words_in_one_level + $item['sum_words_in_dictionary'];
                $user_result_in_one_level = $user_result_in_one_level + $user_result;

                $countDicInOneLevel++;

                if( count( $listDictionaries ) === $queue ){ // Это последний словарь в цикле

                    $min_sum_words = $this->get_min_sum_words_in_one_level( $sum_words_in_one_level );

                    $level_data = [
                        'sum_words' => $sum_words_in_one_level,
                        'min_sum_words' => $min_sum_words,
                        'user_result' => $user_result_in_one_level,
                        'sum_stars_in_one_dictionary' => $scale_stars_for_one_dictionary,
                    ];

                    $oneLevel['level_data'] = $level_data;

                    $levels[ $countLevels ] = $oneLevel;

                };

            }else{ // последний словарь в уровне

                // записывает конечные данные в последний словарь
                $min_sum_words = $this->get_min_sum_words_in_one_level( $sum_words_in_one_level );
                $level_data = [
                    'sum_words' => $sum_words_in_one_level,
                    'min_sum_words' => $min_sum_words,
                    'user_result' => $user_result_in_one_level,
                    'sum_stars_in_one_dictionary' => $scale_stars_for_one_dictionary,
                ];
                $oneLevel['level_data'] = $level_data;
                $levels[ $countLevels ] = $oneLevel;

                // создаёт новый уровень если результат пользователя больше минимального
                if( $min_sum_words <= $user_result_in_one_level ){  
                                                                    
                    $oneLevel = [];
                    $countDicInOneLevel = 0;
                    $sum_words_in_one_level = 0;
                    $user_result_in_one_level = 0;
                    $countLevels++;

                    $oneLevel[$queue] = [
                        'dictionary_id' => $item['dictionary_id'],
                        'sum_words_in_dictionary' => $item['sum_words_in_dictionary'],
                        'user_result' => $user_result,
                        'href' => route( 'training', [ 'queue' => $item['queue'] ] ),
                    ];

                    $sum_words_in_one_level = $sum_words_in_one_level + $item['sum_words_in_dictionary'];
                    $user_result_in_one_level = $user_result_in_one_level + $user_result;

                }else{
                    // результат ползователя меньше минимального, значит новый уровень не зоздаёт
                    // и выходит из цикла
                    break;
                };
                
            };

            
        };

        ksort($levels);

        return $levels;

    }

    private function get_userResult(){
        $usRes = new UserResult();
        $userResult = $usRes->get();
        return $userResult;
    }

    private function get_sum_dictionaries_in_one_level(){
        $sett = $this->settings->where( 'name', '=','sum_dictionaries_in_one_level' )->first();
        $sum_dictionaries_in_one_level = (int)$sett->value;
        return $sum_dictionaries_in_one_level;
    }

    private function get_scale_stars_for_one_dictionary(){
        $sett = $this->settings->where( 'name', '=','scale_stars_for_one_dictionary' )->first();
        $scale_stars_for_one_dictionary = (int)$sett->value;
        return $scale_stars_for_one_dictionary;
    }

    // private function get_passing_score_from_100(){
    //     $sett = $this->settings->where( 'name', '=','passing_score_from_100' )->first();
    //     $passing_score_from_100 = (int)$sett->value;
    //     return $passing_score_from_100;
    // }

    private function get_min_sum_words_in_one_level( $sum_words ){

        // $passing_score_from_100 =  $this->get_passing_score_from_100();

        // $coefficient = 100/$passing_score_from_100;
        // $min = $sum_words/$coefficient;

        // return (int)round( $min, 0, PHP_ROUND_HALF_DOWN);

        return GetMinSumWordsInOneLevel::make( $sum_words );

    }


    

    





    





};

?>