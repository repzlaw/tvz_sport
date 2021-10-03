<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Player;
use App\Models\SportType;
use App\Models\NewsComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompetitionNews;
use App\Models\NewsCommentReply;
use Mews\Purifier\Facades\Purifier;
use App\Models\TeamNewsRelationship;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayerNewsRelationship;
use App\Http\Requests\StoreNewsRequest;
use Symfony\Component\Console\Input\Input;
use App\Http\Requests\StoreNewsCommentRequest;
use App\Http\Requests\StoreNewsCommentReplyRequest;

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

        if ($news->status != 'published') {
            return abort(404,"Page not found"); 
        }

        if (Auth::guard('editor')->check()){
            return view('editor/news/individual-news')->with(['news'=>$news]);
        }

        return view('individual-news')->with(['news'=>$news]);
    }

    //save users comments on news
    public function saveComment(StoreNewsCommentRequest $request)
    {
        // dd($request->all());
        $comment = Purifier::clean($request->comment);

        if (!$comment) {
            session()->flash('error','Invalid comment');
            return back();
        }
        $news = CompetitionNews::findOrFail($request->news_id);
        $comment_count = $news->comment_count + 1;
        
        $user = User::where('id',Auth::id())->with('picture')->firstOrFail();
        $uuid= ((string) Str::uuid());

        $comment = NewsComment::create([
            'uuid'=> $uuid,
            'competition_news_id'=> $request->news_id,
            'content'=> $comment,
            'language'=> $request->language,
            'user_id'=> $user->id,
            'username'=> $user->username,
            'display_name'=> $user->display_name,
            'profile_pic'=> $user->picture? $user->picture->file_path : null,
        ]);
        if ($comment) {
            //update comment count
            $news->update(['comment_count'=>$comment_count]);
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
        $comment = Purifier::clean($request->comment);

        if (!$comment) {
            session()->flash('error','Invalid comment');
            return back();
        }
        $news = CompetitionNews::findOrFail($request->competition_news_id);
        $comment_count = $news->comment_count + 1;
        
        $user = User::where('id',Auth::id())->with('picture')->firstOrFail();

        $uuid= ((string) Str::uuid());

        $comment = NewsComment::create([
            'uuid'=> $uuid,
            'parent_comment_id'=> $request->comment_id,
            'competition_news_id'=> $request->competition_news_id,
            'content'=> $comment,
            'language'=> $request->language,
            'user_id'=> $user->id,
            'username'=> $user->username,
            'display_name'=> $user->display_name,
            'profile_pic'=> $user->picture? $user->picture->file_path : null,
        ]);
        if ($comment) {
            //update comment count
            $news->update(['comment_count'=>$comment_count]);
            $message = 'Reply Saved';
        }else{
            $message = 'Reply failed';
        }

        return redirect()->back()->with(['message'=>$message]);

    }


}
