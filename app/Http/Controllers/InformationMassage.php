<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class InformationMassage extends SiteController
{
    public function __construct(){
        parent::__construct();
        //$this->middleware('auth');

    }

    public function get( $typeMassage = null ){
        
        $section_id_name = 'information_message';
        $this->data['section_id_name'] = $section_id_name;

        $this->setJson([
            'section_id_name' => $section_id_name,

        ]);

        if( view()->exists('default.informationMassage.confirmEmail') ){
            return view( 'default.informationMassage.confirmEmail', $this->data );
        };
        abort(404);

        
    }
}
