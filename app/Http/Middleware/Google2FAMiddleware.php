<?php

namespace App\Http\Middleware;

use App\Support\Google2FAAuthentication;
use PragmaRX\Google2FALaravel\Middleware;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class Google2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guard = activeGuard();
        $getUser =Auth::guard($guard)->user();
        $authentication = app(Google2FAAuthentication::class)->boot($request);
            if(auth()->guard($guard)->check()) {
                if ($getUser->passwordSecurity) {
                    if ($getUser->passwordSecurity->google2fa_enable && $authentication->isAuthenticated()) {
                        if(!is_null(session('2fa'))){
                            return $next($request);
                        }else{
                            return $authentication->makeRequestOneTimePasswordResponse();
                        }
                    }
                }
                return $next($request);
            } 
        
    }
}