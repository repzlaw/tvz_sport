<?php

namespace App\Http\Controllers\Editor;

use App\Models\Team;
use App\Models\Player;
use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PlayerFollower;
use App\Models\PlayerUserEdit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayerNewsRelationship;
use App\Http\Requests\StorePlayerRequest;

class PlayersController extends Controller
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

    //get all players
    public function index()
    {
        $players= Player::orderBy('full_name', 'asc')->get();

        $sport_types = SportType::all();

        $teams = Team::all();
        
        return view('editor/players')->with(['players' => $players, 'sports'=> $sport_types, 'teams'=>$teams]);
    }

    //create player
    public function create(StorePlayerRequest $request)
    {
        if (Auth::guard('editor')->user()->editor_role_id === 1){

            $pagetitle = $request->page_title ? $request->page_title : $request->full_name;
            $metadescription = $request->meta_description ? $request->meta_description : $request->full_name;

            $slug = Str::slug($request->full_name, "-");

            if ($request->hasFile('featured_image')) {
                //process image
                $fileNameToStore = process_image($request->file('featured_image'));

                //store image
                $path = $request->file('featured_image')->storeAs('public/images/player_images', $fileNameToStore);
            }
            else
            {
                $fileNameToStore = '';
            }

            $player = Player::create([
                'sport_type_id'=> $request->sport_type_id,
                'team_id'=> $request->team_id,
                'url_slug'=> $slug,
                'name'=> $request->name,
                'full_name'=> $request->full_name,
                'country'=> $request->country,
                'birth_date'=> $request->birth_date,
                'active_since'=> $request->active_since,
                'status'=> $request->status,
                'role'=> $request->role,
                'signature_hero'=> $request->signature_hero,
                'total_earnings'=> $request->total_earnings,
                'followers'=> $request->followers,
                'summary'=> $request->summary,
                'featured_image'=> $fileNameToStore,
                'page_title'=> $pagetitle,
                'meta_description'=> $metadescription,

            ]);

            if ($player) {
                $message = 'Player Created Successfully!';
            }

            return redirect()->back()->with(['message' => $message]);
        }
    }

    //get a player
    public function getSingle($slug)
    {
        $explode = explode('-',$slug);

        $id = end($explode);

        $sport_types = SportType::all();

        $teams = Team::all();

        $posts = PlayerNewsRelationship::where('player_id', $id)->with('news')->orderBy('created_at','desc')->take(10)->get();

        $player = Player::where('id', $id)->with(['sportType','Team'])->firstOrFail();

        $followers = PlayerFollower::where('player_id', $id)->count();

        return view('editor/individual-player')->with(['player' => $player, 'sports'=> $sport_types, 'teams'=>$teams, 
                                                        'posts'=>$posts,'followers'=>$followers]);

    }

    //edit player
    public function edit(Request $request)
    {
        if (Auth::guard('editor')->user()->editor_role_id === 1){

            $request->validate([
                'sport_type_id' => 'required',
                'full_name' => 'required',
                'team_id' => 'required',
                'name' => 'required',
                'status' => 'required',
                'active_since' => 'required',
            ]);
            $player = Player::findOrFail($request->player_id);

            $pagetitle = $request->page_title ? $request->page_title : $request->full_name;
            $metadescription = $request->meta_description ? $request->meta_description : $request->full_name;
            $slug = Str::slug($request->full_name, "-");

                $update = $player->update([
                    'sport_type_id'=> $request->sport_type_id,
                    'team_id'=> $request->team_id,
                    'name'=> $request->name,
                    'full_name'=> $request->full_name,
                    'country'=> $request->country,
                    'birth_date'=> $request->birth_date,
                    'active_since'=> $request->active_since,
                    'status'=> $request->status,
                    'role'=> $request->role,
                    'signature_hero'=> $request->signature_hero,
                    'total_earnings'=> $request->total_earnings,
                    'followers'=> $request->followers,
                    'summary'=> $request->summary,
                    'page_title'=> $pagetitle,
                    'meta_description'=> $metadescription,
                ]);
                
                if ($update) {
                    $message = 'Player Successfully Updated!';
                }

            return redirect()->back()->with(['message'=>$message]);
        }
    }

    //edit player image
    public function editImage(Request $request)
    {
        if (Auth::guard('editor')->user()->editor_role_id === 1){

            $request->validate([
                'featured_image' => 'file|required|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);
            if ($request->hasFile('featured_image')) {
                //process image
                $fileNameToStore = process_image($request->file('featured_image'));

                //store image
                $path = $request->file('featured_image')->storeAs('public/images/player_images', $fileNameToStore);

                //get old player image if exist
                $player = Player::findOrFail($request->player_id);
                
                $player_image = $player->featured_image;

                if ($player_image) {
                    unlink(storage_path("app/public/images/player_images/".$player_image));
                }

                $update = $player->update([
                    'featured_image'=>$fileNameToStore
                ]);

                if ($update) {
                    $message = 'Player Image Updated!';
                }

                return redirect()->back()->with(['message'=>$message]);
        
            }
        }
    }

    //get player news
    public function getPlayerNews($slug)
    {
        $explode = explode('-',$slug);

        $id = end($explode);

        $posts = PlayerNewsRelationship::where('player_id', $id)->with('news')->orderBy('created_at','desc')->paginate(10);

        $player = Player::where('id', $id)->with(['sportType','Team'])->firstOrFail();

        return view('editor/news/player-news')->with(['player' => $player, 'posts'=>$posts]);
    }
}
