<?php
namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class IsAudio extends Facade {

    protected static function getFacadeAccessor(){
        return 'isaudio';
    }
}
?>