<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index($slug)
    {
        $player = Player::where('url_slug', $slug)->firstOrFail();

        return view('individual-team')->with(['player' => $player]);

    }
}
