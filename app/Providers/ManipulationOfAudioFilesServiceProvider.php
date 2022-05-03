<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Actions\ManipulationOfAudioFilesAction;

class ManipulationOfAudioFilesServiceProvider extends ServiceProvider
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
        $this->app->bind( 'manipulationOfAudioFiles', function(){
            return new ManipulationOfAudioFilesAction();
        });
    }
}
