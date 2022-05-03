<?php

namespace App\Helpers\SharedHelpers;

class ConvertorJSON{


    static public function from_array_to_json( $arr ){

        return json_encode( $arr, JSON_UNESCAPED_UNICODE );;

    }

    static public function from_json_to_array( $json ){

        return json_decode( $json, true);

    }

};




?>






