<?php

namespace App\Http\Controllers\Admin;

use App\Models\ForumPost;
use App\Models\ForumThread;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ForumThreadUpvote;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateForumThreadRequest;

class AdminForumThreadController extends Controller
{
    //create thread
    public function create(StoreThreadRequest $request)
    {
        if (Auth::user()->member_type_id === 1) {
            session()->flash('error',"You are not authorized create thread");
            return back();
        }

        $captcha_secret_key_v3= Configuration::where('key','captcha_secret_key_v3')->first();
        $recaptcha = $request->get('recaptcha');
        $captcha = captchaV3Validation($recaptcha, $captcha_secret_key_v3->value);
        if(!$captcha){
                return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }
        $title = Purifier::clean($request->title);
        if (!$title) {
            session()->flash('error','Invalid forum Thread');
            return back();
        }

        $days = dateDuration(Auth::user()->created_at);
        if ($days < 10) {
            $dayDiff = 10 - $days;
            session()->flash('error',"You have to wait  $dayDiff  days before you can create thread");
            return back();
        }

        $id = Auth::id();
        $slug = Str::slug($title, "-");

        $thread = ForumThread::create([
                    'title'=>$title,
                    'body'=>$request->body,
                    'user_id'=>$id,
                    'url_slug'=>$slug,
                    'forum_category_id'=>$request->forum_category_id,
        ]);

        if ($thread) {
            $message = 'Thread Created Successfully!';
        }

        return back()->with(['message' => $message]);
    }

    //edit thread
    public function edit(UpdateForumThreadRequest $request)
    {
        // dd($request->all());
        $threads = ForumThread::findOrFail($request->thread_id);
        $body = Purifier::clean($request->body);
        $title = Purifier::clean($request->title);

        $id = Auth::id();
        if (!$body || !$title || $threads->user_id != $id) {
            session()->flash('error','Invalid forum thread');
            return back();
        }

        $thread = $threads->update([
                    'title'=>$title,
                    'body'=>$request->body,
        ]);

        if ($thread) {
            $message = 'Thread Updated Successfully!';
        }

        return back()->with(['message' => $message]);
    }

    //get single thread
    public function getSingleThread($slug)
    {
        $explode = explode('-',$slug);
        $id = end($explode);

        $thread = ForumThread::where('id', $id)->with('user.picture')->firstOrFail();
        $posts = ForumPost::where(['forum_thread_id'=>$id])->with('user.picture')->paginate(30);
        $captcha_site_key_v3= Configuration::where('key','captcha_site_key_v3')->first();

        return view('admin/forum/individual-thread')->with(['thread' => $thread, 'posts'=> $posts,
                                                            'captcha_site_key_v3'=>$captcha_site_key_v3->value]);

    }

    //upvote thread
    public function upvoteThread(Request $request)
    {
        $id = Auth::id();
        $upvote = ForumThreadUpvote::where(['user_id'=>$id, 'forum_thread_id'=>$request->thread_id])->first();

        if ($upvote) {
            $upvotes = ForumThreadUpvote::where(['user_id'=>$id, 'forum_thread_id'=>$request->thread_id])->delete();
            if($upvote->type === 'downvote'){
                $upvote = ForumThreadUpvote::firstOrNew([
                    'user_id'=>$id,
                    'forum_thread_id'=>$request->thread_id,
                    'type'=>'upvote'
                ]);
                $upvote->save();
            }
            //update numRecommends column 
            $numupvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'upvote'])->count();
            $numdownvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'downvote'])->count();
            $numRecommends =$numupvotes - $numdownvotes;

            $num = ForumThread::findOrFail($request->thread_id);
            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>false, 'numRecommends'=>$numRecommends]);
            
        } else {
            $upvote = ForumThreadUpvote::firstOrNew([
                'user_id'=>$id,
                'forum_thread_id'=>$request->thread_id,
            ]);
            $upvote->save();

            //update numrecord column 
            $numupvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'upvote'])->count();
            $numdownvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'downvote'])->count();
            $numRecommends =$numupvotes - $numdownvotes;

            $num = ForumThread::findOrFail($request->thread_id);
            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>true, 'numRecommends'=>$numRecommends]);
        }
        
    }

    //downvote thread
    public function downvoteThread(Request $request)
    {
        $id = Auth::id();
        $downvote = ForumThreadUpvote::where(['user_id'=>$id, 'forum_thread_id'=>$request->thread_id])->first();

        if ($downvote) {
            $downvotes = ForumThreadUpvote::where(['user_id'=>$id, 'forum_thread_id'=>$request->thread_id])->delete();
            if($downvote->type === 'upvote'){
                $downvote = ForumThreadUpvote::firstOrNew([
                    'user_id'=>$id,
                    'forum_thread_id'=>$request->thread_id,
                    'type'=>'downvote'
                ]);
                $downvote->save();
            }
            //update numrecord column 
            $numupvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'upvote'])->count();
            $numdownvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'downvote'])->count();
            $numRecommends =$numupvotes - $numdownvotes;

            $num = ForumThread::findOrFail($request->thread_id);
            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>false, 'numRecommends'=>$numRecommends]);
            
        } else {
            $downvote = ForumThreadUpvote::firstOrNew([
                'user_id'=>$id,
                'forum_thread_id'=>$request->thread_id,
                'type'=>'downvote'
            ]);
            $downvote->save();

            //update numrecord column 
            $numupvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'upvote'])->count();
            $numdownvotes = ForumThreadUpvote::where(['forum_thread_id'=>$request->thread_id, 'type'=>'downvote'])->count();
            $numRecommends =$numupvotes - $numdownvotes;

            $num = ForumThread::findOrFail($request->thread_id);
            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>true, 'numRecommends'=>$numRecommends]);
        }
        
    }
}
