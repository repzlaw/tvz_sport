<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AdminLoginLog;
use App\Models\EditorLoginLog;
use App\Http\Controllers\Controller;

class LoginLogsController extends Controller
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
    
    //admin login log view
    public function adminView()
    {

        $logs = AdminLoginLog::orderBy('created_at','desc')->with('admin')->paginate(50);

        return view('admin/loginLogs/adminLoginLogs')->with(['logs'=>$logs]);
    }

    //editor login log view
    public function editorView()
    {

        $logs = EditorLoginLog::orderBy('created_at','desc')->with('editor')->paginate(50);

        return view('admin/loginLogs/editorLoginLogs')->with(['logs'=>$logs]);
    }

}
