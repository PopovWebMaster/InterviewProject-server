<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;

use App\Helpers\ModelHelpers\Dictionaries\ListDictionaries\GetListDictionariesFromClient;


class DictionariesController extends SiteController
{
    //
    public function __construct(){
        parent::__construct();
        //$this->middleware('auth');

    }

    public function get(){
        $section_id_name = 'dictionaries';
        $this->data['section_id_name'] = $section_id_name;
        $this->setJson([
            'section_id_name' => $section_id_name,
            'listDictionaries' => GetListDictionariesFromClient::make(),
        ]);

        if( view()->exists('default.dictionaries') ){
            return view( 'default.dictionaries', $this->data );
        };
        abort(404);

        
    }
}
