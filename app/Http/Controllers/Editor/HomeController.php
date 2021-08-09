<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Only auth for "editor" guard are allowed 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('editor')->except('logout');
    }
    /**
     * Show editor Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('editor.home');
    }
}
