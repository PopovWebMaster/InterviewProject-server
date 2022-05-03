<?php

namespace App\Helpers\SharedHelpers;

use App\Settings;


class GetMinSumWordsInOneLevel {

    static public function make( $sum_words ){

        $settings = new Settings();
       
        $setting = $settings->where( 'name', '=','passing_score_from_100' )->first();
        $passing_score_from_100 = (int)$setting->value;

        $coefficient = 100/$passing_score_from_100;
        $min = $sum_words/$coefficient;

        return (int)round( $min, 0, PHP_ROUND_HALF_DOWN);

    }



}


?>