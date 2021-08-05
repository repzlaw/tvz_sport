<?php

namespace App\Http\Middleware;

use App\Models\BanPolicy;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CheckBanned
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
        if ($next) {
            if (auth()->check() && auth()->user()->status === 'banned' ) {
                $reason = BanPolicy::findOrFail(auth()->user()->policy_id);
                if (auth()->user()->ban_till !== null) {
                    if (auth()->user()->ban_till && now()->lessThan(auth()->user()->ban_till)) {
                        $banned_days = now()->diffInDays(auth()->user()->ban_till);
            
                        if ($banned_days > 14) {
                            $error = 'Your account has been suspended for '. $reason->reason;
                            auth()->logout();
                            return redirect()->route('login')->withMessage($error);
                        } else {
                            $error = 'Your account has been suspended for '.$banned_days.' '.Str::plural('day', $banned_days)
                                .' for '. $reason->reason;
                            auth()->logout();
                            return redirect()->route('login')->withMessage($error);
                        }
                    }
                    
                }else{
                    $error = 'Your account has been suspended indefinitely '.' for '. $reason->reason;
                    auth()->logout();
                    return redirect()->route('login')->withMessage($error);
                }
                // auth()->logout();
                
                // return redirect()->route('login')->withMessage($error);
            }
    
        }

        return $next($request);
    }

}
