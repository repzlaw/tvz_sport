<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminLoginLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Google2faController extends Controller
{
    public function g2faVerify(Request $request)
    {
        $guard = activeGuard();
        $getUser =Auth::guard($guard)->user();
        $google2fa = app('pragmarx.google2fa');
            if($google2fa->verifyGoogle2FA($getUser->passwordSecurity->google2fa_secret, $request->one_time_password)){
                session(['2fa' => true]);
                return redirect(URL()->previous());
                // return redirect()->route($guard.'.home')->with(['message'=>'2fa verified succesfully']);
            }
           
            return back()->with(['error'=>'Invalid Token Supplied']);
    }

     /**
     * Logout 
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $guard = activeGuard();
        if ($guard === 'admin') {
            //log login logs
            //log information on logins table
            $admin = Auth::guard('admin')->user();
            $browser_info = getBrowser();
            $session_id = session()->getId();
                    
            $login_log = AdminLoginLog::create([
                'admin_id' => $admin->id,
                'action' => 'logout',
                'last_login_ip' => $request->getClientIp(),
                'browser_info' => json_encode($browser_info),
                'session_id' => $session_id,
            ]);
        }
        
      //logout the admin...
      Auth::guard($guard)->logout();
      Session::flush();
        return redirect()
        ->route($guard.'.login')
        ->with('status','Admin has been logged out!');
    }

}
