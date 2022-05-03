<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Settings;

class SiteIsClosedController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $settings = new Settings;
        $site_is_closed = $settings->get_a_value_for_a_single_setting( 'site_is_closed' );

        if( !$site_is_closed ){
            return redirect()->route('home');
        };

        if( view()->exists('default.site_is_closed') ){
            return view( 'default.site_is_closed', $this->data );
        };
        abort(404);
    }
}
