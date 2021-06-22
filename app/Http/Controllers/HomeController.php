<?php

namespace App\Http\Controllers;

use App\Models\Competitions;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Competitions::all();
        // $matches = Matc
        
        return view('welcome')->with(['events'=> $events]);

    }
}
