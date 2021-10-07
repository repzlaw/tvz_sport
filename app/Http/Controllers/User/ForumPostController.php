<?php

namespace App\Http\Controllers\User;

use App\Models\BanPolicy;
use App\Models\ForumPost;
use Illuminate\Support\Str;
use App\Models\ReportedPost;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ForumCategory;
use App\Models\ForumPostUpvote;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReportPostRequest;
use App\Http\Requests\StoreForumPostRequest;
use App\Http\Requests\UpdateForumPostRequest;
use App\Models\ForumThread;

class ForumPostController extends Controller
{
    //create post
    public function create(StoreForumPostRequest $request)
    {
        // dd($request->all());
        $posts = ForumPost::where('user_id',Auth::id())->latest()->first();
        if ($posts) {
            $diff_in_minutes = now()->diffInMinutes($posts->created_at);
            if($diff_in_minutes < 2){
                return back()->withErrors(['error' => 'you have to wait till two minutes to post again']);
            }
        }

        $captcha_secret_key_v3= Configuration::where('key','captcha_secret_key_v3')->first();
        $recaptcha = $request->get('recaptcha');
        $captcha = captchaV3Validation($recaptcha, $captcha_secret_key_v3->value);
        if(!$captcha){
            return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }
        $body = Purifier::clean($request->body);

        if (!$body) {
            session()->flash('error','Invalid forum Post');
            return back();
        }

        $days = dateDuration(Auth::user()->created_at);
        if ($days < 10) {
            $dayDiff = 10 - $days;
            session()->flash('error',"You have to wait  $dayDiff  days before you can post");
            return back();
        }

        $id = Auth::id();

        if (Auth::user()->member_type_id === 1) {
            $post = ForumPost::create([
                        'status'=>'underreview',
                        'body'=>$request->body,
                        'user_id'=>$id,
                        'forum_thread_id'=>$request->forum_thread_id,
            ]);

            if ($post) {
                $message = 'Post Under review';
            }
        }else{
            $post = ForumPost::create([
                // 'title'=>$title,
                'body'=>$request->body,
                'user_id'=>$id,
                'forum_thread_id'=>$request->forum_thread_id,
            ]);

            if ($post) {
                $message = 'Post Created Successfully!';
            }
        }



        return back()->with(['message' => $message]);
    }

    //edit post
    public function edit(UpdateForumPostRequest $request)
    {
        // dd($request->all());

        $posts = ForumPost::findOrFail($request->post_id);
        $body = Purifier::clean($request->body);

        $captcha_secret_key_v3= Configuration::where('key','captcha_secret_key_v3')->first();
        $recaptcha = $request->get('recaptcha');
        $captcha = captchaV3Validation($recaptcha, $captcha_secret_key_v3->value);
        if(!$captcha){
            return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }
        $id = Auth::id();
        if (!$body || $posts->user_id != $id) {
            session()->flash('error','Invalid forum Post');
            return back();
        }
        if (Auth::user()->member_type_id === 1) {
            $post = $posts->update([
                'status'=>'underreview',
                'body'=>$request->body,
            ]);
            if ($post) {
                $message = 'Post Under review';
            }
        }else{
            $post = $posts->update([
                        // 'title'=>$title,
                        'body'=>$request->body,
            ]);
            if ($post) {
                $message = 'Post Updated Successfully!';
            }
        }

        return back()->with(['message' => $message]);
    }

    //upvote post
    public function upvotePost(Request $request)
    {
        $id = Auth::id();
        $upvote = ForumPostUpvote::where(['user_id'=>$id, 'forum_post_id'=>$request->post_id])->first();

        if ($upvote) {
            $upvotes = ForumPostUpvote::where(['user_id'=>$id, 'forum_post_id'=>$request->post_id])->delete();
            if($upvote->type === 'downvote'){
                $upvote = ForumPostUpvote::firstOrNew([
                    'user_id'=>$id,
                    'forum_post_id'=>$request->post_id,
                    'type'=>'upvote'
                ]);
                $upvote->save();
            }
            //update numRecommends column 
            $numupvotes = ForumPostUpvote::where(['forum_post_id'=>$request->post_id, 'type'=>'upvote'])->count();
            $numdownvotes = ForumPostUpvote::where(['forum_post_id'=>$request->post_id, 'type'=>'downvote'])->count();
            $numRecommends =$numupvotes - $numdownvotes;
            $num = Forumpost::findOrFail($request->post_id);
            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>false, 'numRecommends'=>$numRecommends]);
            
        } else {
            $upvote = ForumPostUpvote::firstOrNew([
                'user_id'=>$id,
                'forum_post_id'=>$request->post_id,
            ]);
            $upvote->save();

            //update numrecord column 
            $numupvotes = ForumPostUpvote::where(['forum_post_id'=>$request->post_id, 'type'=>'upvote'])->count();
            $numdownvotes = ForumPostUpvote::where(['forum_post_id'=>$request->post_id, 'type'=>'downvote'])->count();
            $numRecommends =$numupvotes - $numdownvotes;

            $num = Forumpost::findOrFail($request->post_id);
            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>true, 'numRecommends'=>$numRecommends]);
        }
        
    }

    //report thread
    public function reportPost($slug)
    {
        // $explode = explode('-',$slug);
        // $id = end($explode);
        $policies= BanPolicy::where('type','post')->get();
        // dd($slug);
        
        return view('user.forum.report-post')->with(['policies'=> $policies, 'post_id'=>$slug]);
    }

    //create report
    public function createReport(ReportPostRequest $request)
    {
        // dd($request->all());
        $report = ReportedPost::create([
                    'policy_id'=>$request->policy_id,
                    'user_notes'=>$request->user_notes,
                    'post_id'=>$request->forum_post_id,
                    'user_id'=>Auth::id(),
        ]);

        if($report){
            $post = ForumPost::findOrFail($request->forum_post_id);
            $posts = $post->update([
                'status'=>'reported',
            ]);
            $forum = ForumThread::findOrFail($post->forum_thread_id);

            return redirect()->route('forum.thread.get.single', ['thread_slug' => $forum->url_slug.'-'.$forum->id ])
                            ->with('message', 'Post reported succesfully');
        }

    }

}
