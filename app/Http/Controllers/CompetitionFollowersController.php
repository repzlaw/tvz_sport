<?php

namespace App\Http\Controllers;

use App\Models\CompetitionFollower;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionFollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //follow or unfollow competition
    public function followCompetition(Request $request, $id)
    {
        $follow = competitionFollowSystem($id);

        return $follow;
    }

}
