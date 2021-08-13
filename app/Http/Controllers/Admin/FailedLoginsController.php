<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminFailedLoginAttempt;
use App\Models\EditorFailedLoginAttempt;
use Illuminate\Http\Request;

class FailedLoginsController extends Controller
{
     /**
     * Only auth for "admin" guard are allowed 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    //admin failed login  view
    public function adminView()
    {
        $logs = AdminFailedLoginAttempt::orderBy('created_at','desc')->with('admin')->paginate(50);
// return($logs);
        return view('admin/failedLogins/adminFailedLogins')->with(['logs'=>$logs]);
    }

    //editor failed login view
    public function editorView()
    {
        $logs = EditorFailedLoginAttempt::orderBy('created_at','desc')->with('editor')->paginate(50);

        return view('admin/failedLogins/editorFailedLogins')->with(['logs'=>$logs]);
    }
}
