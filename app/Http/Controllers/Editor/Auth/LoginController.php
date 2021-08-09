<?php

namespace App\Http\Controllers\Editor\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Editor;
use App\Models\EditorLoginLog;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('editor.login',[
            'title' => 'Editor Login',
            'loginRoute' => 'editor.login',
            'forgotPasswordRoute' => 'editor.password.request'
        ]);
    }

    /**
     * Login the editor.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validator($request);
    
        //attempt login.
        if(Auth::guard('editor')->attempt($request->only('email','password'),$request->filled('remember'))){
            //log information on logins table
            $editor = Editor::where('email',$request->email)->first();
            $browser_info = getBrowser();
            $session_id = session()->getId();
                    
            $login_log = EditorLoginLog::create([
                'editor_id' => $editor->id,
                'last_login_ip' => $request->getClientIp(),
                'browser_info' => json_encode($browser_info),
                'session_id' => $session_id,
            ]);

            //Authenticated
            return redirect()
                ->intended(route('editor.home'))
                ->with(['status'=>'You are Logged in as Editor!']);
        }
        //Authentication failed
        return $this->loginFailed();
    }

    /**
     * Logout the editor.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        //log information on logins table
        $editor = Auth::guard('editor')->user();
        $browser_info = getBrowser();
        $session_id = session()->getId();
                
        $login_log = EditorLoginLog::create([
            'editor_id' => $editor->id,
            'action' => 'logout',
            'last_login_ip' => $request->getClientIp(),
            'browser_info' => json_encode($browser_info),
            'session_id' => $session_id,
        ]);
        
      //logout the editor...
      Auth::guard('editor')->logout();
        return redirect()
        ->route('editor.login')
        ->with('status','Editor has been logged out!');
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
            'email'    => 'required|email|exists:editors|min:5|max:191',
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
