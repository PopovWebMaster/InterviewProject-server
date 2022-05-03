<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use App\User;

class AccessRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next ){

        if( Auth::check() ){

            $id = Auth::id();
            $user = User::find( $id );

            if( $user->access ){
                return $next($request);

            }else{
                return redirect()->route('admin');
            };
        }else{
            return redirect()->route('admin');

        };  
    }
}
