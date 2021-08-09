<?php

namespace App\Http\Controllers\Editor;

use App\Models\Team;
use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTeamRequest;
use App\Models\TeamNewsRelationship;
use App\Models\TeamUserEdit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    /**
     * Only auth for "editor" guard are allowed 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('editor')->except('logout');
    }
    //get all teams
    public function index()
    {
        $teams= Team::orderBy('team_name', 'asc')->get();

        $sport_types = SportType::all();
        
        return view('editor/teams')->with(['teams' => $teams, 'sports'=> $sport_types]);
    }

    //create team
    public function create(StoreTeamRequest $request)
    {
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

        return redirect()->back()->with(['message' => $message]);

    }

    //get single team
    public function getSingle($slug)
    {
        $explode = explode('-',$slug);
        $id = end($explode);
        $team = Team::where('id', $id)->with('sportType')->firstOrFail();

        $posts = TeamNewsRelationship::where('team_id', $id)->with('news')->orderBy('created_at','desc')->get();

        $sport_types = SportType::all();

        return view('editor/individual-team')->with(['team' => $team, 'sports'=> $sport_types, 'posts'=>$posts]);

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

        $team = Team::findOrFail($request->team_id);

        $pagetitle = $request->page_title ? $request->page_title : $request->team_name;
        $metadescription = $request->meta_description ? $request->meta_description : $request->team_name;
        $slug = Str::slug($request->team_name, "-");

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

        return redirect()->back()->with(['message'=>$message]);
    }

    //edit team image
    public function editImage(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
    
            return redirect()->back()->with(['message'=>$message]);
        }
    }
}
