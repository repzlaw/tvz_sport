<?php
namespace App\Services\Users\Comments;

use App\Models\NewsComment;
use App\Models\TeamComment;
use App\Models\MatchComment;
use App\Models\PlayerComment;

class CommentService
{
    //get news comments
    public function newsComments($id, $lang, $orderColumn, $ordertype, $language, $page){
        $comments = NewsComment::where(['competition_news_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','competition_news_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);

        foreach ($comments as $key => $com) {
            $replies = NewsComment::where(['parent_comment_id'=> $com->id])
                                    ->get(['id','competition_news_id','username','profile_pic','display_name',
                                        'parent_comment_id','user_id','content','created_at','numRecommends',
                                        ]);
            $com->reply = $replies;
        }
        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

    //get players comments
    public function playerComments($id, $lang, $orderColumn, $ordertype, $language, $page)
    {
        $comments = PlayerComment::where(['player_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->with(['user:id,username,display_name','user.picture:user_id,file_path'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','competition_news_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);

        foreach ($comments as $key => $com) {
            $replies = PlayerComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,display_name','user.picture:user_id,file_path'])
                                        ->get(['id','competition_news_id','username','profile_pic','display_name',
                                                'parent_comment_id','user_id','content','created_at','numRecommends',
                                                ]);
            $com->reply = $replies;

        }
        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

    //get players comments
    public function teamComments($id, $lang, $orderColumn, $ordertype, $language, $page)
    {
        $comments = TeamComment::where(['team_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->with(['user:id,username,display_name','user.picture:user_id,file_path'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','competition_news_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);

        foreach ($comments as $key => $com) {
            $replies = TeamComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,display_name','user.picture:user_id,file_path'])
                                    ->get(['id','competition_news_id','username','profile_pic','display_name',
                                                'parent_comment_id','user_id','content','created_at','numRecommends',
                                                ]);
            $com->reply = $replies;

        }
        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

    //get players comments
    public function matchComments($id, $lang, $orderColumn, $ordertype, $language, $page)
    {
        $comments = MatchComment::where(['match_id'=>$id, 'parent_comment_id'=> null, 'language'=>$lang])
                                            ->with(['user:id,username,display_name','user.picture:user_id,file_path'])
                                            ->orderBy($orderColumn,$ordertype)
                                            ->select('id','competition_news_id','username','profile_pic','display_name',
                                                    'parent_comment_id','user_id','content','created_at',
                                                    'numRecommends')
                                            ->simplePaginate($page);
                
        foreach ($comments as $key => $com) {
            $replies = MatchComment::where(['parent_comment_id'=> $com->id])->with(['user:id,username,display_name','user.picture:user_id,file_path'])
                                    ->get(['id','competition_news_id','username','profile_pic','display_name',
                                                'parent_comment_id','user_id','content','created_at','numRecommends',
                                                ]);
            $com->reply = $replies;

        }
        $summary = (object) ['lang_iso'=>$language, 'language'=>$lang];

        return response()->json(['summary'=>$summary,'comments'=> $comments]);
    }

}