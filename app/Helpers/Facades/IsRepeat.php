<?php
namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class IsRepeat extends Facade {

    protected static function getFacadeAccessor(){
        return 'isrepeat';
    }
}
?>