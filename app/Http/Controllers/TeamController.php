<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTeamRequest;

class TeamController extends Controller
{
    //get all teams
    public function index()
    {
        $teams= Team::orderBy('updated_at', 'desc')->get();

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

                // Get filename with the extension
                $filenameWithExt = $request->file('featured_image')->getClientOriginalName();
                //get file name with the extension
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //get just extension
                $extension = $request->file('featured_image')->getClientOriginalExtension();
                
                //filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                
                //upload image
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
        // dd($team);

        return view('individual-team')->with(['team' => $team]);

    }
}
