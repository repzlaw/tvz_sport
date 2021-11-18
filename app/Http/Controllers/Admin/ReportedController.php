<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ReportedThread;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ReportedController extends Controller
{
    public function getThread()
    {
        $threads = DB::table('tvz_sport_forum.reported_threads as rt')
                        ->join('tvz_sport_forum.forum_threads as ft','rt.thread_id','ft.id')
                        ->join('ban_policies as bp','rt.policy_id','bp.id')
                        ->join('users as u','rt.user_id','u.id')
                        ->select('u.username','bp.reason','rt.user_notes','ft.title','ft.body','rt.created_at')
                        ->latest()
                        ->get();

        return view('admin.reported.threads')->with(['threads'=>$threads]);
    }

    public function getPost()
    {
        $posts = DB::table('tvz_sport_forum.reported_posts as rt')
                        ->join('tvz_sport_forum.forum_posts as ft','rt.post_id','ft.id')
                        ->join('ban_policies as bp','rt.policy_id','bp.id')
                        ->join('users as u','rt.user_id','u.id')
                        ->select('u.username','bp.reason','rt.user_notes','ft.title','ft.body','rt.created_at')
                        ->latest()
                        ->get();

        return view('admin.reported.posts')->with(['posts'=>$posts]);
    }

    public function getNewsComment()
    { 
        $api_url = Configuration::where('key','comment_api_url')->first();
        $api_key = Configuration::where('key','comment_api_key')->first();

        $posts = Http::withHeaders([
            'X-Api-Key' => $api_key->value
        ])->get($api_url->value."reported/news-comment")->json();
        
        // dd($posts);
        // $posts = DB::table('tvz_sport_comment.reported_news_comments as rt')
        //                 ->join('tvz_sport_comment.news_comments as ft','rt.comment_id','ft.id')
        //                 ->join('ban_policies as bp','rt.policy_id','bp.id')
        //                 ->join('users as u','rt.user_id','u.id')
        //                 ->select('u.username','bp.reason','rt.user_notes','ft.content','rt.created_at')
        //                 ->latest()
        //                 ->get();

        return view('admin.reported.news-comment')->with(['posts'=>$posts]);
    }

    public function getPlayersComment()
    {
        $api_url = Configuration::where('key','comment_api_url')->first();
        $api_key = Configuration::where('key','comment_api_key')->first();

        $posts = Http::withHeaders([
            'X-Api-Key' => $api_key->value
        ])->get($api_url->value."reported/players-comment")->json();
        
        return view('admin.reported.players-comment')->with(['posts'=>$posts]);
    }

    public function getTeamsComment()
    {
        $api_url = Configuration::where('key','comment_api_url')->first();
        $api_key = Configuration::where('key','comment_api_key')->first();

        $posts = Http::withHeaders([
            'X-Api-Key' => $api_key->value
        ])->get($api_url->value."reported/teams-comment")->json();
        return view('admin.reported.teams-comment')->with(['posts'=>$posts]);
    }
}
