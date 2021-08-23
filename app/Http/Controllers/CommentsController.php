<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use Illuminate\Http\Request;
use App\Models\CompetitionNews;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetCommentRequest;
use App\Models\MatchComment;
use App\Models\PlayerComment;
use App\Models\TeamComment;

class CommentsController extends Controller
{
    //get comments based on specified parameters
    public function getComments(GetCommentRequest $request)
    {
        $id = $request->get('c');
        $category = $request->get('cat');
        $language = $request->get('lang');

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
                $comments = NewsComment::where(['competition_news_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->with(['user:id,username,created_at'])->orderBy('created_at','desc')->get();
                
                $total = count($comments);
    
                foreach ($comments as $key => $com) {
                    $replies = NewsComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,created_at'])->get();
                    $com->reply = $replies;
                    $total++;
                }
                return response()->json(['lang_iso'=>$language, 'language'=>$lang, 'total'=>$total, 'comments'=> $comments]);
            }
            elseif ($category === 'players') {
                $comments = PlayerComment::where(['player_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->with(['user:id,username,created_at'])->orderBy('created_at','desc')->get();
    
                $total = count($comments);
                
                foreach ($comments as $key => $com) {
                    $replies = PlayerComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,created_at'])->get();
                    $com->reply = $replies;
                    $total++;

                }
                return response()->json(['lang_iso'=>$language, 'language'=>$lang, 'total'=>$total, 'comments'=> $comments]);
    
            }
            elseif ($category === 'teams') {
                $comments = TeamComment::where(['team_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->with(['user:id,username,created_at'])->orderBy('created_at','desc')->get();

                $total = count($comments);
                
                foreach ($comments as $key => $com) {
                    $replies = TeamComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,created_at'])->get();
                    $com->reply = $replies;
                    $total++;

                }
                return response()->json(['lang_iso'=>$language, 'language'=>$lang, 'total'=>$total, 'comments'=> $comments]);
    
            }
            elseif ($category === 'matches') {
                $comments = MatchComment::where(['match_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->with(['user:id,username,created_at'])->orderBy('created_at','desc')->get();

                $total = count($comments);
                
                foreach ($comments as $key => $com) {
                    $replies = MatchComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,created_at'])->get();
                    $com->reply = $replies;
                    $total++;

                }
                return response()->json(['lang_iso'=>$language, 'language'=>$lang, 'total'=>$total, 'comments'=> $comments]);
    
            }
        }

    }
}
