<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Models\SportType;
use App\Models\PlayerNews;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePlayerRequest;

class PlayerController extends Controller
{
    //get all players
    public function index()
    {
        $players= Player::orderBy('full_name', 'asc')->get();

        $sport_types = SportType::all();

        $teams = Team::all();
        
        return view('players')->with(['players' => $players, 'sports'=> $sport_types, 'teams'=>$teams]);
    }

    //create player
    public function create(StorePlayerRequest $request)
    {
        $user = Auth::user();
        if ($user->user_type === 'editor') {

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

            $team = Player::create([
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

            if ($team) {
                $message = 'Player Created Successfully!';
            }

            return redirect('/players')->with(['message' => $message]);
        }
        return abort(404,"Page not found");

    }

    //get a player
    public function getSingle($slug)
    {
        $explode = explode('-',$slug);
        $id = end($explode);

        $sport_types = SportType::all();

        $teams = Team::all();

        $posts = PlayerNews::where('player_id', $id)->with('news')->orderBy('created_at','desc')->get();


        $player = Player::where('id', $id)->with(['sportType','Team'])->firstOrFail();
        return view('individual-player')->with(['player' => $player, 'sports'=> $sport_types, 'teams'=>$teams, 'posts'=>$posts]);

    }

    //edit player
    public function edit(Request $request)
    {
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

        return redirect()->route('player.get.single', ['player_slug' => $player->url_slug.'-'.$player->id ])->with(['message'=>$message]);
    }

    //edit player image
    public function editImage(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('featured_image')) {
            //process image
            $fileNameToStore = process_image($request->file('featured_image'));

            //store image
            $path = $request->file('featured_image')->storeAs('public/images/player_images', $fileNameToStore);

            //get old team image if exist
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

            return redirect()->route('player.get.single', ['player_slug' => $player->url_slug.'-'.$player->id ])->with(['message'=>$message]);
    
        }
    }
}
