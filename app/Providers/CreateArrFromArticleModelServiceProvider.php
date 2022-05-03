<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\Actions\CreateArrFromArticleModelAction;

class CreateArrFromArticleModelServiceProvider extends ServiceProvider
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
        $this->app->bind('CreateArrFromArticleModel', function(){
            return new CreateArrFromArticleModelAction();
        });
    }
}
