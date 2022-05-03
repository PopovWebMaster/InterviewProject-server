<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Actions\IsRepeatAction;

class IsRepeatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('isrepeat', function(){
            return new IsRepeatAction();
        });
    }
}
