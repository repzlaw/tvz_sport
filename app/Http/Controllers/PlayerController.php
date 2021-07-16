<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePlayerRequest;
use App\Models\Team;

class PlayerController extends Controller
{
    //get all players
    public function index()
    {
        $players= Player::orderBy('updated_at', 'desc')->get();

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

                // Get filename with the extension
                $filenameWithExt = $request->file('featured_image')->getClientOriginalName();
                //get file name with the extension
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //get just extension
                $extension = $request->file('featured_image')->getClientOriginalExtension();
                
                //filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                
                //upload image
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

        $player = Player::where('id', $id)->with(['sportType','Team'])->firstOrFail();
        return view('individual-player')->with(['player' => $player]);

    }
}
