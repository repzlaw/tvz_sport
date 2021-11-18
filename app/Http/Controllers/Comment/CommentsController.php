<?php

namespace App\Http\Controllers\Comment;

use App\Models\NewsComment;
use App\Models\TeamComment;
use App\Models\MatchComment;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\PlayerComment;
use App\Models\CompetitionNews;
use App\Models\NewsCommentUpvote;
use App\Models\TeamCommentUpvote;
use App\Models\MatchCommentUpvote;
use App\Models\PlayerCommentUpvote;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\GetCommentRequest;
use App\Http\Requests\StoreUpvoteRequest;
use App\Http\Requests\DeleteCommentRequest;
use App\Services\Users\Comments\CommentService;
use App\Http\Requests\GetIndividualCommentRequest;

class CommentsController extends Controller
{
    protected $CommentService;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentService $CommentService)
    {
        $this->CommentService = $CommentService;
    }

    //get comments based on specified parameters
    public function getComments(GetCommentRequest $request)
    {
        $api_url = Configuration::where('key','comment_api_url')->first();
        $api_key = Configuration::where('key','comment_api_key')->first();

        $response = Http::withHeaders([
                'X-Api-Key' => $api_key->value
            ])->get($api_url->value.'v1/comments/',[
                'pages' => $request->get('pages'),
                'c' => $request->get('c'),
                'lang' => $request->get('lang'),
                'cat' => $request->get('cat'),
                'orderby' => $request->get('orderby'),
        ])->json();
        return $response;

    }
    
    //delete comment
    public function deleteComment(DeleteCommentRequest $request)
    {
        $comment_id = $request->get('comment_id');
        $user_id = $request->get('user_id');
        $mod = $request->get('mod');

        $model = '';
        if ($mod === 'news') {
            $model = 'App\Models\NewsComment';
        } else if($mod === 'player') {
            $model = 'App\Models\PlayerComment';
        } else if($mod === 'team') {
            $model = 'App\Models\TeamComment';
        } else if($mod === 'match') {
            $model = 'App\Models\MatchComment';
        }

        if ($model) {
            if (Auth::id() == $user_id) {
                $comment = $model::findOrFail($comment_id);
                $comment->delete();
                return response()->json(['status'=>true, 'comment_id'=>$comment_id]);
            }
        }

    }

    //delete reply
    public function deleteReply(DeleteCommentRequest $request)
    {
        $comment_id = $request->get('comment_id');
        $user_id = $request->get('user_id');
        $mod = $request->get('mod');

        $model = '';
        if ($mod === 'news') {
            $model = 'App\Models\NewsComment';
        } else if($mod === 'player') {
            $model = 'App\Models\PlayerComment';
        } else if($mod === 'team') {
            $model = 'App\Models\TeamComment';
        } else if($mod === 'match') {
            $model = 'App\Models\MatchComment';
        }

        if ($model) {
            if (Auth::id() == $user_id) {
                $comment = $model::findOrFail($comment_id);
                $comment->delete();
                return response()->json(['status'=>true, 'comment_id'=>$comment_id]);
            }
        }

    }

    //check if user upvoted a comment
    public function checkUpvote(StoreUpvoteRequest $request)
    {
        $mod = $request->get('cat');
        $comment_id = $request->get('comment_id');
        $user_id = Auth::id();
        
        $check = checkUpvoted($mod, $comment_id, $user_id);

        return $check->getData()->status;
    }

    //upvote or remove upvote
    public function upvoteComment(StoreUpvoteRequest $request)
    {
        $mod = $request->get('cat');
        $comment_uuid = $request->get('comment_id');

        $api_url = Configuration::where('key','comment_api_url')->first();
        $api_key = Configuration::where('key','comment_api_key')->first();

        $response = Http::withHeaders([
            'X-Api-Key' => $api_key->value
        ])->get($api_url->value."v1/comments/upvote-comment", [
            'mod'=> $mod,
            'comment_uuid'=> $comment_uuid,
            'user_id'=> Auth::id(),
        ])->json();
        
        return $response;
    
    }

    //get single user comment
    public function getUserComment(GetIndividualCommentRequest $request)
    {
        $model ='';
        $mod = $request->get('cat');
        $id = Auth::id();

        if ($mod === 'news') {
            $model = 'App\Models\NewsComment';
        } else if($mod === 'player') {
            $model = 'App\Models\PlayerComment';
        } else if($mod === 'team') {
            $model = 'App\Models\TeamComment';
        } else if($mod === 'match') {
            $model = 'App\Models\MatchComment';
        }

        if ($model) {
            $comments = $model::where('user_id',$id)->latest()->get();
            return view('userProfile/user-comments')->with(['type'=>$mod,'comments'=>$comments]);
        }
        
    }
}
