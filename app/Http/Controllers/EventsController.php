<?php

namespace App\Http\Controllers;

use App\Models\Competitions;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    //event view page
    public function index($slug)
    {
        $event = Competitions::where('url_slug',$slug)->firstOrFail();

        return view('individual-event')->with(['event' =>  $event]);

    }
}
