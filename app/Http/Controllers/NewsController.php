<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Player;
use App\Models\BanPolicy;
use App\Models\SportType;
use App\Models\NewsComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\CompetitionNews;
use App\Models\NewsCommentReply;
use App\Models\ReportedNewsComment;
use Mews\Purifier\Facades\Purifier;
use App\Models\TeamNewsRelationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\PlayerNewsRelationship;
use App\Http\Requests\StoreNewsRequest;
use Symfony\Component\Console\Input\Input;
use App\Http\Requests\ReportCommentRequest;
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
        $captcha_site_key_v3= Configuration::where('key','captcha_site_key_v3')->first();

        if ($news->status != 'published') {
            return abort(404,"Page not found"); 
        }

        if (Auth::guard('editor')->check()){
            return view('editor/news/individual-news')->with(['news'=>$news]);
        }

        return view('individual-news')->with(['news'=>$news,'captcha_site_key_v3'=>$captcha_site_key_v3->value]);
    }

    //save users comments on news
    public function saveComment(StoreNewsCommentRequest $request)
    {
        
        if (!preg_match('/[^A-Za-z0-9 ]/', $request->comment)) 
        {
            $captcha_secret_key_v3= Configuration::where('key','captcha_secret_key_v3')->first();
            $recaptcha = $request->get('recaptcha');
            $captcha = captchaV3Validation($recaptcha, $captcha_secret_key_v3->value);
            if(!$captcha){
                    return back()->withErrors(['captcha' => 'ReCaptcha Error']);
            }

            $comment = Purifier::clean($request->comment);

            if (!$comment) {
                session()->flash('error','Invalid comment');
                return back();
            }
            $news = CompetitionNews::findOrFail($request->news_id);
            $comment_count = $news->comment_count + 1;
            
            $user = User::where('id',Auth::id())->with('picture')->firstOrFail();
            $uuid= ((string) Str::uuid());

            $api_url = Configuration::where('key','comment_api_url')->first();
            $api_key = Configuration::where('key','comment_api_key')->first();

            $response = Http::withHeaders([
                'api_key' => $api_key->value
            ])->post($api_url->value."v1/comments/save-news-comment", [
                'uuid'=> $uuid,
                'competition_news_id'=> $request->news_id,
                'content'=> $comment,
                'language'=> $request->language,
                'user_id'=> $user->id,
                'username'=> $user->username,
                'display_name'=> $user->display_name,
                'profile_pic'=> $user->picture? $user->picture->file_path : null,
            ]);
            
            if ($response->json()['result'] =='ok') {
                //update comment count
                $news->update(['comment_count'=>$comment_count]);
                $message = 'Comment Saved';
            }else{
                $message = 'Comment failed';
            }

            return redirect()->back()->with(['message'=>$message]);
        }else{
            return back()->withErrors(['language' => 'Input only english letters and numbers']);
        }
    }

    //save users comments replies 
    public function saveReply(StoreNewsCommentReplyRequest $request)
    {
        // dd($request->all());
        if (!preg_match('/[^A-Za-z0-9 ]/', $request->comment)) 
        {
            $captcha_secret_key_v3= Configuration::where('key','captcha_secret_key_v3')->first();
            $recaptcha = $request->get('recaptcha');
            $captcha = captchaV3Validation($recaptcha, $captcha_secret_key_v3->value);
            if(!$captcha){
                    return back()->withErrors(['captcha' => 'ReCaptcha Error']);
            }

            $comment = Purifier::clean($request->comment);

            if (!$comment) {
                session()->flash('error','Invalid comment');
                return back();
            }
            $news = CompetitionNews::findOrFail($request->competition_news_id);
            $comment_count = $news->comment_count + 1;
            
            $user = User::where('id',Auth::id())->with('picture')->firstOrFail();

            $uuid= ((string) Str::uuid());

            $api_url = Configuration::where('key','comment_api_url')->first();
            $api_key = Configuration::where('key','comment_api_key')->first();

            $response = Http::withHeaders([
                'api_key' => $api_key->value
            ])->post($api_url->value."v1/comments/save-news-reply", [
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
            // dd($response->json());
            if ($response->json()['result'] =='ok') {
                //update comment count
                $news->update(['comment_count'=>$comment_count]);
                $message = 'Reply Saved';
            }else{
                $message = 'Reply failed';
            }

            return redirect()->back()->with(['message'=>$message]);
        }else{
            return back()->withErrors(['language' => 'Input only english letters and numbers']);
        }
    }

    //report comment
    public function reportComment($id)
    {
        $policies= BanPolicy::where('type','comment')->get();
        return view('user.news.report-comment')->with(['policies'=> $policies, 'comment_id'=>$id]);
    }

    //create report
    public function createReport(ReportCommentRequest $request)
    {
        // dd($request->all());
        $api_url = Configuration::where('key','comment_api_url')->first();
        $api_key = Configuration::where('key','comment_api_key')->first();

        $response = Http::withHeaders([
            'api_key' => $api_key->value
        ])->post($api_url->value."v1/comments/report-news-comment", [
            'policy_id'=>$request->policy_id,
            'user_notes'=>$request->user_notes,
            'comment_id'=>$request->comment_id,
            'user_id'=>Auth::user()->username,
        ])->json();
// dd($response);
        // $report = ReportedNewsComment::create([
        //             'policy_id'=>$request->policy_id,
        //             'user_notes'=>$request->user_notes,
        //             'comment_id'=>$request->comment_id,
        //             'user_id'=>Auth::id(),
        // ]);

        if($response['result'] =='ok'){
        //     $post = NewsComment::findOrFail($request->comment_id);
        //     $posts = $post->update([
        //         'status'=>'reported',
        //     ]);
            $news = CompetitionNews::findOrFail($response['competition_news_id']);

            return redirect()->route('news.get.single', ['news_slug' => $news->url_slug.'-'.$news->id ])
                            ->with('message', 'Comment reported succesfully');
        }

    }

}
