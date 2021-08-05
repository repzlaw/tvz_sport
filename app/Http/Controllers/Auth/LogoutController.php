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
        auth()->logout();

        //log information on logins table
        $browser_info = getBrowser();
                    
        $login_log = UserLoginLog::create([
            'user_id' => $id,
            'last_login_ip' => $request->getClientIp(),
            'browser_info' => json_encode($browser_info),
            'action' => 'logout',
        ]);

        return redirect('/');
    }
}
