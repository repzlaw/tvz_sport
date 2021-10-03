<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\SportType;
use App\Models\TeamComment;
use Illuminate\Support\Str;
use App\Models\TeamFollower;
use App\Models\TeamUserEdit;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use App\Models\TeamNewsRelationship;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTeamRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTeamCommentRequest;
use App\Http\Requests\StoreTeamCommentReplyRequest;

class TeamController extends Controller
{
    //get all teams
    public function index()
    {
        $teams= Team::orderBy('team_name', 'asc')->get();

        $sport_types = SportType::all();
        
        return view('teams')->with(['teams' => $teams, 'sports'=> $sport_types]);
    }

    //create team
    public function create(StoreTeamRequest $request)
    {
        $user = Auth::user();
        if ($user->user_type === 'editor') {

            $pagetitle = $request->page_title ? $request->page_title : $request->team_name;
            $metadescription = $request->meta_description ? $request->meta_description : $request->team_name;

            $slug = Str::slug($request->team_name, "-");

            if ($request->hasFile('featured_image')) {
                //process image
                $fileNameToStore = process_image($request->file('featured_image'));

                 //store image
                $path = $request->file('featured_image')->storeAs('public/images/team_images', $fileNameToStore);
            }
            else
            {
                $fileNameToStore = '';
            }

            $team = Team::create([
                'sport_type_id'=> $request->sport_type_id,
                'url_slug'=> $slug,
                'team_name'=> $request->team_name,
                'summary'=> $request->summary,
                'featured_image'=> $fileNameToStore,
                'page_title'=> $pagetitle,
                'meta_description'=> $metadescription,

            ]);

            if ($team) {
                $message = 'Team Created Successfully!';
            }

            return redirect('/teams')->with(['message' => $message]);
        }
        return abort(404,"Page not found");

    }

    //get single team
    public function getSingle($slug)
    {
        $explode = explode('-',$slug);
        $id = end($explode);
        $team = Team::where('id', $id)->with('sportType')->firstOrFail();

        $posts = TeamNewsRelationship::where('team_id', $id)->with('news')->orderBy('created_at','desc')->take(10)->get();

        $sport_types = SportType::all();

        $followers = TeamFollower::where('team_id', $id)->count();


        return view('individual-team')->with(['team' => $team, 'sports'=> $sport_types,
                                             'posts'=>$posts,'followers'=>$followers]);

    }

    //edit team
    public function edit(Request $request)
    {
        $request->validate([
            'team_name' => 'required',
            'team_id' => 'required',
            'summary' => 'required',
            'sport_type_id' => 'required',
        ]);
        // dd($request->all());

        $team = Team::findOrFail($request->team_id);

        $pagetitle = $request->page_title ? $request->page_title : $request->team_name;
        $metadescription = $request->meta_description ? $request->meta_description : $request->team_name;
        $slug = Str::slug($request->team_name, "-");


        if (Auth::user()->user_type === 'editor') {
            $update = $team->update([
                'sport_type_id'=> $request->sport_type_id,
                'team_name'=> $request->team_name,
                'summary'=> $request->summary,
                'page_title'=> $pagetitle,
                'meta_description'=> $metadescription,
            ]);
            
            if ($update) {
                $message = 'Team Successfully Updated!';
            }
        }elseif (Auth::user()->user_type === 'user') {
            $update = TeamUserEdit::firstOrNew([
                'team_id' => $team->id,
                'approval_status' => 'pending',
                'user_id'=> Auth::user()->id,
            ]);
            $update->url_slug= $slug;
            $update->sport_type_id= $request->sport_type_id;
            $update->team_name= $request->team_name;
            $update->summary= $request->summary;
            $update->page_title= $pagetitle;
            $update->meta_description= $metadescription;
            $update->save();
            
            if ($update) {
                $message = 'Request for Team Update Successful!';
            }
            
        }

        return redirect()->route('team.get.single', ['team_slug' => $team->url_slug.'-'.$team->id ])->with(['message'=>$message]);
    }

    //edit team image
    public function editImage(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        if ($request->hasFile('featured_image')) {
            //process image
            $fileNameToStore = process_image($request->file('featured_image'));

            //store image
            $path = $request->file('featured_image')->storeAs('public/images/team_images', $fileNameToStore);

            //get old team image if exist
            $team = Team::findOrFail($request->team_id);
            
            $team_image = $team->featured_image;

            if ($team_image) {
                unlink(storage_path("app/public/images/team_images/".$team_image));
            }

            $update = $team->update([
                'featured_image'=>$fileNameToStore
            ]);

            if ($update) {
                $message = 'Team Image Updated!';
            }
    
            return redirect()->route('team.get.single', ['team_slug' => $team->url_slug.'-'.$team->id ])->with(['message'=>$message]);
        }
    }

    //get Team news
    public function getTeamNews($slug)
    {
        $explode = explode('-',$slug);

        $id = end($explode);

        $posts = TeamNewsRelationship::where('team_id', $id)->with('news')->orderBy('created_at','desc')->paginate(10);

        $team = Team::where('id', $id)->with(['sportType'])->firstOrFail();

        return view('team-news')->with(['team' => $team, 'posts'=>$posts]);
    }

    //save users comments on news
    public function saveComment(StoreTeamCommentRequest $request)
    {
        // dd($request->all());
        $comment = Purifier::clean($request->comment);

        if (!$comment) {
            session()->flash('error','Invalid comment');
            return back();
        }
        $news = Team::findOrFail($request->team_id);
        $comment_count = $news->comment_count + 1;
        $user = User::where('id',Auth::id())->with('picture')->firstOrFail();
        $uuid= ((string) Str::uuid());

        $comment = TeamComment::create([
            'uuid'=> $uuid,
            'team_id'=> $request->team_id,
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
    public function saveReply(StoreTeamCommentReplyRequest $request)
    {
        $comment = Purifier::clean($request->comment);

        if (!$comment) {
            session()->flash('error','Invalid comment');
            return back();
        }
        $news = Team::findOrFail($request->team_id);
        $comment_count = $news->comment_count + 1;
        $user = User::where('id',Auth::id())->with('picture')->firstOrFail();
        $uuid= ((string) Str::uuid());

        $comment = TeamComment::create([
            'uuid'=> $uuid,
            'parent_comment_id'=> $request->comment_id,
            'team_id'=> $request->team_id,
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
