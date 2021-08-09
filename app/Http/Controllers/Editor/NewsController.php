<?php

namespace App\Http\Controllers\Editor;

use App\Models\SportType;
use Illuminate\Support\Str;
use App\Models\CompetitionNews;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreNewsRequest;
use App\Models\PlayerNewsRelationship;
use App\Models\TeamNewsRelationship;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('editor');
    }

    //return post news page
    public function index()
    {
        $editor = Auth::guard('editor')->user();

        $editorsNews= CompetitionNews::where('posted_by', $editor->id)->with(['playernews.player','teamnews.team'])->orderBy('updated_at','desc')->get();
        $sport_types = SportType::all();
        
        return view('editor/post-news')->with(['posts' => $editorsNews, 'sports'=> $sport_types]);
    }

    //create news function
    public function createNews(StoreNewsRequest $request)
    {
        $teams = $request->input('teams');
        $players = $request->input('players');

        $teamsID = [];
        $playersID = [];

        if ($teams) {
            $teamsID= explode(",", $teams);
        }

        if ($players) {
            $playersID= explode(",", $players);
        }
        // dd($playersID);
        $pagetitle = $request->page_title ? $request->page_title : $request->news_title;
        $metadescription = $request->meta_description ? $request->meta_description : $request->news_title;

        $slug = Str::slug($request->news_title, "-");

        $post = CompetitionNews::create([
                'sport_type_id'=> $request->sport_type,
                'url_slug'=> $slug,
                'headline'=> $request->news_title,
                'content'=> $request->news_body,
                'posted_by'=> Auth::guard('editor')->user()->id,
                'page_title'=> $pagetitle,
                'meta_description'=> $metadescription,
        ]);
        if ( $post) {
            //insert record into playernews table
            if ($playersID) {
                foreach ($playersID as $key => $id) {
                    $playernews = PlayerNewsRelationship::create([
                        'player_id'=>$id,
                        'competition_news_id'=> $post->id
                    ]);
                }
            }
            //insert record into team news table
            if ($teamsID) {
                foreach ($teamsID as $key => $id) {
                    $teamnews = TeamNewsRelationship::create([
                        'team_id'=>$id,
                        'competition_news_id'=> $post->id
                    ]);
                }
            }
            $message = 'Post Successfully Created!';
        }
        return redirect()->back()->with(['message' => $message]);
    }

    //edit news
    public function editNews(Request $request)
    {
        $request->validate([
            'news_body' => 'required',
            'postId' => 'required',
            'news_title' => 'required',
            'sport_type' => 'required',
        ]);
        // dd($request->all());
        $post = CompetitionNews::findOrFail($request->postId);

        $pagetitle = $request->page_title ? $request->page_title : $request->news_title;
        $metadescription = $request->meta_description ? $request->meta_description : $request->news_title;

        $post->update([
            'sport_type_id'=> $request->sport_type,
            'headline'=> $request->news_title,
            'content'=> $request->news_body,
            'page_title'=> $pagetitle,
            'meta_description'=> $metadescription,
        ]);
        if ($post) {
            if ($request->has('teams')) {
                $teamsID = $request->input('teams');

                foreach ($teamsID as $key => $id) {
                    $teamnews = TeamNewsRelationship::firstOrNew([
                        'team_id'=>$id,
                        'competition_news_id'=> $post->id
                    ]);
                    $teamnews->save();
                }
            }

            if ($request->has('players')) {
                $playersID = $request->input('players');

                foreach ($playersID as $key => $id) {
                    $playernews = PlayerNewsRelationship::firstOrNew([
                        'player_id'=>$id,
                        'competition_news_id'=> $post->id
                    ]);
                    $playernews->save();
                }
            }
            $message = 'Post Successfully Updated!';
        }

        return response()->json(['post' => $post, 'message'=>$message],200);
    }

    //delete news
    public function deleteNews($id)
    {
        $post = CompetitionNews::findOrFail($id);

         if (auth()->guard('editor')->user()->id !== $post->posted_by) {
            
             return redirect()->back()->with('error','You cannot delete this post');

         }

        $playernews = PlayerNewsRelationship::where('competition_news_id',$post->id)->delete();
        $teamnews = TeamNewsRelationship::where('competition_news_id',$post->id)->delete();
        $post->delete();
        return redirect()->back()->with('message','Post Deleted');
    
    }

    //get individual news page
    public function getSingleNews($news_slug)
    {
        $explode = explode('-',$news_slug);
        $id = end($explode);

        $news = CompetitionNews::where(['id'=>$id])->with('user')->firstOrFail();

        return view('editor/individual-news')->with(['news'=>$news]);
    }

    // fun to search player
    public function searchPlayer(Request $request)
    {
        // dd($request->all());
        
        if ($request->ajax()) {
            $q = $request->input('q');
            $from = $request->input('from');
            $output = searchPlayer($q, $from);

            return $output;
        }
    }

    // fun to search team
    public function searchTeam(Request $request)
    {
        if ($request->ajax()) {
            $q = $request->input('q');
            $from = $request->input('from');

            $output= searchTeam($q, $from);

            return $output;
        }
    }

    //delete player related to news
    public function deletePlayer($id)
    {
        $player = PlayerNewsRelationship::where('id',$id)->delete();

        return redirect()->back()->with(['message' => 'player deleted from news']);
    }

    //delete team related to news
    public function deleteTeam($id)
    {
        $team = TeamNewsRelationship::where('id',$id)->delete();

        return redirect()->back()->with(['message' => 'team deleted from news']);
    }

}