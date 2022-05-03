<?php

Route::auth();

Route::get(
    '/', 
    [
        'uses' => 'HomeController@get', 
        'as' => 'home',
        'middleware' => [ 'web', 'siteIsClosed' ]
    ]
);

Route::group( [ 
        'prefix' => 'en',
        'name' => 'en',
        'middleware' => [ 'auth', 'siteIsClosed' ]
    ], function () {

    Route::get( '/', ['uses' => 'EnController@get', 'as'=>'en' ]);
    Route::post('/', ['uses' => 'EnController@post'] );

    Route::get( '/dictionaries', ['uses' => 'DictionariesController@get', 'as'=>'dictionaries' ]);
    Route::post('/dictionaries', ['uses' => 'DictionariesController@post'] );

    Route::get( '/training/{queue?}', ['uses' => 'TrainingController@get', 'as'=>'training' ]);
    Route::post('/training/{queue?}', ['uses' => 'TrainingController@post'] );

    }
);

Route::get( '/site-is-closed',    ['uses' => 'SiteIsClosedController@get',  'as'=>'site_is_closed' ]);

Route::get( '/information-massage/{typeMassage?}', ['uses' => 'InformationMassage@get',   'as' => 'information_massage' ]);

Route::get( '/register',    ['uses' => 'Auth\RegisterController@get', 'middleware' => [ 'siteIsClosed' ],  'as'=>'register' ]);
Route::post( '/register',   ['uses' => 'Auth\RegisterController@post' ]);

Route::get( '/login',       [ 'uses' => 'Auth\LoginController@get',      'as'=>'login' ]);
Route::post( '/login',      [ 'uses' => 'Auth\LoginController@post' ]);

Route::get( '/reset-password',    ['uses' => 'Auth\PasswordResetController@get', 'middleware' => [ 'siteIsClosed' ], 'as'=>'reset_password' ]);
Route::post( '/reset-password',   ['uses' => 'Auth\PasswordResetController@post' ]);



Route::get( '/confirm-email',         ['uses' => 'Auth\ConfirmEmailController@get',  'middleware' => [ 'siteIsClosed' ] ]);
Route::get( '/confirm-email/{token}', ['uses' => 'Auth\ConfirmEmailController@get',  'middleware' => [ 'siteIsClosed' ], 'as'=>'confirm_email' ]);


//Route::get('storage/audio/{id}/{filename}', ['uses'=>'TrainingController@audio']);


// Route::get(
//     '/dictionaries', 
//     [
//         'uses'=>'DictionariesController@get', 
//         'as'=>'dictionaries',
//         'middleware' => [ 'auth' ]
//     ]
// );

// Route::get(
//     '/training/{numDict?}', 
//     [
//         'uses'=>'TrainingController@get', 
//         'as'=>'training',
//         'middleware' => [ 'auth' ]
//     ]
// );







// Route::get('storage/audio/{id}/{filename}', ['uses'=>'TrainingController@audio']);









Route::group( [ 'prefix' => 'admin' ], function () {

    Route::get( '/', ['uses'=>'Admin\AdminController@get', 'as'=>'admin' ]);
    Route::post('/', ['uses'=>'Admin\AdminController@post'] );

    Route::group( [
            'prefix' => '/workspace',
            'name' => 'admin',
            'middleware' => [ 'access', 'siteIsClosed'] //'auth',
        ], 
        function(){

            Route::get('/', ['uses' => 'Admin\HomeController@get', 'as' => 'admin_home']);
            Route::post('/', [ 'uses' => 'Admin\HomeController@post' ]);

            Route::get('/projects', [ 'uses' => 'Admin\ProjectsController@get', 'as' => 'admin_projects' ]);
            Route::post('/projects', [ 'uses' => 'Admin\ProjectsController@post' ]);
            
            Route::get('/project/{id}', [ 'uses' => 'Admin\ProjectController@get', 'as' => 'admin_project' ])->where('id', '[0-9]+');
            Route::post('/project/{id}', [ 'uses' => 'Admin\ProjectController@post' ])->where('id', '[0-9]+');

            Route::get('/analysis', ['uses' => 'Admin\AnalysisController@get', 'as' => 'admin_analysis']);
            Route::post('/analysis', ['uses' => 'Admin\AnalysisController@post' ]);

            Route::get('/dictionaries', ['uses' => 'Admin\DictionariesController@get', 'as' => 'admin_dictionaries']); // !!!!
            Route::post('/dictionaries', ['uses' => 'Admin\DictionariesController@post' ]);

            Route::get('/dictionary/{id}', ['uses' => 'Admin\DictionaryController@get', 'as' => 'admin_dictionary'])->where('id', '[0-9]+');
            Route::post('/dictionary/{id}', ['uses' => 'Admin\DictionaryController@post' ])->where('id', '[0-9]+');

            Route::get('/anticipation', ['uses' => 'Admin\AnticipationController@get', 'as' => 'admin_anticipation']);
            Route::post('/anticipation', ['uses' => 'Admin\AnticipationController@post' ]);

            Route::get('/setting', ['uses' => 'Admin\SettingController@get', 'as' => 'admin_setting']);
            Route::post('/setting', ['uses' => 'Admin\SettingController@post' ]);

            Route::get('/articles', ['uses' => 'Admin\ArticlesController@get', 'as' => 'admin_articles']);
            // Route::post('/articles', ['uses' => 'Admin\ArticlesController@post' ]); // <- НЕ УДАЛЯТЬ !!!!!

            Route::get('/article/{alias}', ['uses' => 'Admin\ArticleController@get', 'as' => 'admin_article']);
            Route::post('/article/{alias}', ['uses' => 'Admin\ArticleController@post' ]);

            Route::get('/addarticle', ['uses' => 'Admin\AddArticleController@get', 'as' => 'admin_addarticle']);
            Route::post('/addarticle', ['uses' => 'Admin\AddArticleController@post' ]);

            Route::get('/advertising', ['uses' => 'Admin\AdvertisingController@get', 'as' => 'admin_advertising']);
            Route::post('/advertising', ['uses' => 'Admin\AdvertisingController@post' ]);

            //Route::post('/upload/{id}', ['uses' => 'Admin\UploadAudioController@post', 'as' => 'admin_uploadAudio' ])->where('id', '[0-9]+');//врем!!!!!
            Route::post('/audio/{id}', ['uses' => 'Admin\AudioController@post', 'as' => 'admin_audio' ])->where('id', '[0-9]+');



        }
    );

    //Route::get( '/workspace', ['uses' => 'AdminWorkspaceController@show', 'middleware'=>['auth', 'access'], 'as' => 'admin_workspace'] );

    //Route::post( '/workspace', ['uses' => 'AdminWorkspaceController@vrem', 'middleware'=>['auth', 'access'] ] );

});






