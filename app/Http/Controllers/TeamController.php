<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index($slug)
    {
        $team = Team::where('url_slug', $slug)->firstOrFail();

        return view('individual-team')->with(['team' => $team]);

    }
}
