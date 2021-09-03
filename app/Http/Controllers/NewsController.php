<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Models\SportType;
use App\Models\NewsComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompetitionNews;
use App\Models\TeamNewsRelationship;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayerNewsRelationship;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\StoreNewsCommentRequest;
use App\Http\Requests\StoreNewsCommentReplyRequest;
use App\Models\NewsCommentReply;

class NewsController extends Controller
{
    /**
     * Only auth for "auth" guard are allowed 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('getSingleNews');
    }

    //get individual news page
    public function getSingleNews($news_slug)
    {
        $explode = explode('-',$news_slug);
        $id = end($explode);

        $news = CompetitionNews::where(['id'=>$id])->with(['user','playernews.player','teamnews.team'])->firstOrFail();
        // $comments = NewsComment::where(['competition_news_id'=>$id, 'parent_comment_id'=> null])->with(['user:id,username,created_at'])->orderBy('created_at','desc')->get();

        // foreach ($comments as $key => $com) {
        //    $replies = NewsComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,created_at'])->get();
        //    $com->reply = $replies;
        // }
        
// return $comments;
        if (Auth::guard('editor')->check()){
            return view('editor/news/individual-news')->with(['news'=>$news]);
        }

        return view('individual-news')->with(['news'=>$news]);
    }

    //save users comments on news
    public function saveComment(StoreNewsCommentRequest $request)
    {
        // dd($request->all());
        
        $user_id = Auth::id();
        $uuid= ((string) Str::uuid());

        $comment = NewsComment::create([
            'uuid'=> $uuid,
            'competition_news_id'=> $request->news_id,
            'content'=> $request->comment,
            'language'=> $request->language,
            'user_id'=> $user_id,
        ]);
        if ($comment) {
            $message = 'Comment Saved';
        }else{
            $message = 'Comment failed';
        }

        return redirect()->back()->with(['message'=>$message]);

    }

    //save users comments replies 
    public function saveReply(StoreNewsCommentReplyRequest $request)
    {
        // dd($request->all());
        
        $user_id = Auth::id();
        $uuid= ((string) Str::uuid());

        $comment = NewsComment::create([
            'uuid'=> $uuid,
            'parent_comment_id'=> $request->comment_id,
            'competition_news_id'=> $request->competition_news_id,
            'content'=> $request->comment,
            'language'=> $request->language,
            'user_id'=> $user_id,
        ]);
        if ($comment) {
            $message = 'Reply Saved';
        }else{
            $message = 'Reply failed';
        }

        return redirect()->back()->with(['message'=>$message]);

    }


}
