<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompetitionNews;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreNewsRequest;
use App\Models\PlayerNewsRelationship;
use App\Models\TeamNewsRelationship;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('getSingleNews');
    }

    //get individual news page
    public function getSingleNews($news_slug)
    {
        $explode = explode('-',$news_slug);
        $id = end($explode);

        $news = CompetitionNews::where(['id'=>$id])->with('user')->firstOrFail();

        return view('individual-news')->with(['news'=>$news]);
    }


}
