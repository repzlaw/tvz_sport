<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\AdminLoginLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     * 
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest:admin')->except('logout');
    // }

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
//         $google2fa = app('pragmarx.google2fa');

// return $google2fa->generateSecretKey();
        return view('admin.login',[
            'title' => 'Admin Login',
            'loginRoute' => 'admin.login',
            'forgotPasswordRoute' => 'admin.password.request'
        ]);
    }

    /**
     * Login the admin.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validator($request);
    
        //attempt login.
        if(Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember'))){
            //log login logs
            //log information on logins table
            $admin = Admin::where('email',$request->email)->first();
            $browser_info = getBrowser();
            $session_id = session()->getId();
                    
            $login_log = AdminLoginLog::create([
                'admin_id' => $admin->id,
                'last_login_ip' => $request->getClientIp(),
                'browser_info' => json_encode($browser_info),
                'session_id' => $session_id,
            ]);
            //Authenticated
            return redirect()
                ->intended(route('admin.home'))
                ->with(['status'=>'You are Logged in as Admin!']);
        }
        //Authentication failed
        return $this->loginFailed();
    }

    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
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
        
      //logout the admin...
      Auth::guard('admin')->logout();
      Session::flush();
        return redirect()
        ->route('admin.login')
        ->with('status','Admin has been logged out!');
    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        session()->flash('message','Incorrect Password');
        return back();
    }
    
}
