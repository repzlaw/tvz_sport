<?php

namespace App\Http\Controllers\Comment;

use App\Models\NewsComment;
use App\Models\TeamComment;
use App\Models\MatchComment;
use Illuminate\Http\Request;
use App\Models\PlayerComment;
use App\Models\CompetitionNews;
use App\Models\NewsCommentUpvote;
use App\Models\TeamCommentUpvote;
use App\Models\MatchCommentUpvote;
use App\Models\PlayerCommentUpvote;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GetCommentRequest;
use App\Http\Requests\StoreUpvoteRequest;
use App\Http\Requests\DeleteCommentRequest;
use App\Http\Requests\GetIndividualCommentRequest;
use App\Services\Users\Comments\CommentService;

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
        $id = $request->get('c');
        $category = $request->get('cat');
        $language = $request->get('lang');
        $orderColumn = 'created_at';
        $ordertype = 'desc';
        $order = $request->get('orderby');
        if ($order === 'oldest') {
            $ordertype = 'asc';
        }elseif ($order === 'upvote') {
            $orderColumn = 'numRecommends';
        }
        $page = 50;
        if ($request->has('pages')) {
            $page = $page * $request->get('pages');
        }
        
        //get language specified
        $lang= '';
        
        if ($language == 'en-US' || $language == 'en-us') {
            $lang = 'English';
        }elseif ($language === 'pt') {
            $lang = 'Portuguese';
        }elseif ($language === 'es') {
            $lang = 'Spanish';
        }elseif ($language === 'ru') {
            $lang = 'Russian';
        }

        if ($lang) {
            //get comments based on category specified
            if ($category === 'news') {
                $comments = $this->CommentService->newsComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            } elseif ($category === 'players') {
                $comments = $this->CommentService->playerComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            } elseif ($category === 'teams') {
                $comments = $this->CommentService->teamComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            } elseif ($category === 'matches') {
                $comments = $this->CommentService->matchComments($id, $lang, $orderColumn, $ordertype, $language, $page);
                return $comments;
            }
        }

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
        $mod = $request->get('model');
        $comment_id = $request->get('comment_id');
        $user_id = Auth::id();
        
        $check = checkUpvoted($mod, $comment_id, $user_id);

        return $check->getData()->status;
    }

    //upvote or remove upvote
    public function upvoteComment(StoreUpvoteRequest $request)
    {
        $mod = $request->get('model');
        $comment_id = $request->get('comment_id');
        $user_id = Auth::id();

        $check = checkUpvoted($mod, $comment_id, $user_id);
        $check = $check->getData();
        if ($check->status) {
            $upvote = $check->model::where(['user_id'=>$user_id, 'comment_id'=>$comment_id])->delete();

            //update numrecord column 
            $num = $check->parentModel::findOrFail($comment_id);
            $numRecommends =$num->numRecommends - 1;
            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>false, 'numRecommends'=>$numRecommends]);
        }else {
            $upvote = $check->model::firstOrNew([
                            'user_id'=>$user_id,
                            'comment_id'=>$comment_id,
            ]);
            $upvote->save();

            //update numrecord column 
            $num = $check->parentModel::findOrFail($comment_id);
            $numRecommends =$num->numRecommends + 1;

            $numrecord = $num->update([
                'numRecommends'=> $numRecommends,
            ]);
            return response()->json(['status'=>true, 'numRecommends'=>$numRecommends]);
        }
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
