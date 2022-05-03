<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use App\Settings;
// use Auth;
// use App\User;



use App\Helpers\SharedHelpers\GetUserAccessRights;

class SiteIsClosed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        $settings = new Settings;
        $site_is_closed = $settings->get_a_value_for_a_single_setting( 'site_is_closed' );

        if( $site_is_closed ){
            if( $path !== 'site-is-closed' || $path !== 'login' ){
                if( !GetUserAccessRights::isAdmin() ){
                    return redirect()->route('site_is_closed');
                };
            };

        }else{
            if( $path === 'site-is-closed'){
                return redirect()->route('home');
            };

        };

        return $next($request);
    }
}
