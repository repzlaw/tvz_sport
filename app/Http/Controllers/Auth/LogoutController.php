<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserLoginLog;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //logout func
    public function logout(Request $request)
    {
        $id = Auth::user()->id;

        //log information on logins table
        $browser_info = getBrowser();
        $session_id = session()->getId();
                    
        $login_log = UserLoginLog::create([
            'user_id' => $id,
            'last_login_ip' => $request->getClientIp(),
            'browser_info' => json_encode($browser_info),
            'action' => 'logout',
            'session_id' => $session_id,
        ]);

        auth()->logout();

        return redirect('/');
    }
}
