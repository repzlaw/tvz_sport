<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MatchEvent;
use App\Models\Competitions;
use Illuminate\Http\Request;
use App\Models\CompetitionNews;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

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
        $expiresAt = Carbon::now()->endOfDay()->addSecond();
        //get upcoming events
        $upcomingevents= cache()->remember('homepage-latest-event', $expiresAt, function(){
            return MatchEvent::whereDate('match_date', Carbon::today())->orderBy('match_time', 'asc')->with('user','homeTeam','awayTeam')->get();
        }); 
        //get past events
        $previousevents= cache()->remember('homepage-previous-event', $expiresAt, function(){
            return MatchEvent::whereDate('match_date','!=', Carbon::today())->orderBy('match_time', 'asc')->with('user','homeTeam','awayTeam')->get();
        }); 
        //get latest news
        $latestnews= cache()->remember('homepage-latest-news', $expiresAt, function(){
            return CompetitionNews::where('status','published')
                                    ->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->with('user','competition')->get();
        });
        //get past news
        $previousnews= cache()->remember('homepage-previous-news', $expiresAt, function(){
            return CompetitionNews::where('status','published')
                                    ->whereDate('created_at','!=', Carbon::today())->orderBy('created_at', 'desc')->with('user','competition')->get();
        });

        return view('welcome')->with(['upcomingevents'=> $upcomingevents, 'previousevents'=>$previousevents, 'latestnews'=> $latestnews, 'previousnews'=>$previousnews]);

    }
}
