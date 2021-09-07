<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Competitions;
use Illuminate\Http\Request;
use App\Models\CompetitionNews;
use App\Models\MatchEvent;

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
        //get upcoming events
        $upcomingevents = MatchEvent::whereDate('match_date', Carbon::today())->orderBy('match_time', 'asc')->with('user','homeTeam','awayTeam')->get();

        //get past events
        $previousevents = MatchEvent::whereDate('match_date','!=', Carbon::today())->orderBy('match_time', 'asc')->with('user','homeTeam','awayTeam')->get();

        //get latest news
        $latestnews = CompetitionNews::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->with('user','competition')->get();

        //get past news
        $previousnews = CompetitionNews::whereDate('created_at','!=', Carbon::today())->orderBy('created_at', 'desc')->with('user','competition')->get();
        
        return view('welcome')->with(['upcomingevents'=> $upcomingevents, 'previousevents'=>$previousevents, 'latestnews'=> $latestnews, 'previousnews'=>$previousnews]);

    }
}
