<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Player;
use App\Models\BanPolicy;
use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\PlayerComment;
use App\Models\PlayerFollower;
use App\Models\PlayerUserEdit;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\ReportedPlayerComment;
use App\Models\PlayerNewsRelationship;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\ReportCommentRequest;
use App\Http\Requests\StorePlayerCommentRequest;
use App\Http\Requests\StorePlayerCommentReplyRequest;

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

        $posts = PlayerNewsRelationship::where('player_id', $id)->with('news')->orderBy('created_at','desc')->take(10)->get();

        $followers = PlayerFollower::where('player_id', $id)->count();
        $captcha_site_key_v3= Configuration::where('key','captcha_site_key_v3')->first();

        $player = Player::where('id', $id)->with(['sportType','Team'])->firstOrFail();
        return view('individual-player')->with(['player' => $player, 'sports'=> $sport_types, 
                                                'teams'=>$teams, 'posts'=>$posts,'followers'=>$followers,
                                                'captcha_site_key_v3'=>$captcha_site_key_v3->value]);

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
        $slug = Str::slug($request->full_name, "-");

        if (Auth::user()->user_type === 'editor') {

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
        }elseif (Auth::user()->user_type === 'user') {
            $update = PlayerUserEdit::firstOrNew([
                'player_id' => $player->id,
                'approval_status' => 'pending',
                'user_id'=> Auth::user()->id,
            ]);
            $update->url_slug= $slug;
            $update->sport_type_id= $request->sport_type_id;
            $update->team_id= $request->team_id;
            $update->name= $request->name;
            $update->full_name= $request->full_name;
            $update->country= $request->country;
            $update->birth_date= $request->birth_date;
            $update->active_since= $request->active_since;
            $update->status= $request->status;
            $update->role= $request->role;
            $update->signature_hero= $request->signature_hero;
            $update->total_earnings= $request->total_earnings;
            $update->followers= $request->followers;
            $update->summary= $request->summary;
            $update->page_title= $pagetitle;
            $update->meta_description= $metadescription;
            $update->save();
            
            if ($update) {
                $message = 'Request for Player Update Successful!';
            }
        }

        return redirect()->route('player.get.single', ['player_slug' => $player->url_slug.'-'.$player->id ])->with(['message'=>$message]);
    }

    //edit player image
    public function editImage(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
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

            return redirect()->route('player.get.single', ['player_slug' => $player->url_slug.'-'.$player->id ])->with(['message'=>$message]);
    
        }
    }

    //get player news
    public function getPlayerNews($slug)
    {
        $explode = explode('-',$slug);

        $id = end($explode);

        $posts = PlayerNewsRelationship::where('player_id', $id)->with('news')->orderBy('created_at','desc')->paginate(10);

        $player = Player::where('id', $id)->with(['sportType','Team'])->firstOrFail();

        return view('player-news')->with(['player' => $player, 'posts'=>$posts]);
    }

    //save users comments on news
    public function saveComment(StorePlayerCommentRequest $request)
    {
        // dd($request->all());
        if (!preg_match('/[^A-Za-z0-9 ]/', $request->comment)) 
        {
            // string contains only english letters & digits
            $captcha_secret_key_v3= Configuration::where('key','captcha_secret_key_v3')->first();
            $recaptcha = $request->get('recaptcha');
            $captcha = captchaV3Validation($recaptcha, $captcha_secret_key_v3->value);
            if(!$captcha){
                    return back()->withErrors(['captcha' => 'ReCaptcha Error']);
            }

            $comment = Purifier::clean($request->comment);

            if (!$comment) {
                session()->flash('error','Invalid comment');
                return back();
            }
            $news = Player::findOrFail($request->player_id);
            $comment_count = $news->comment_count + 1;
            $user = User::where('id',Auth::id())->with('picture')->firstOrFail();
            
            $uuid= ((string) Str::uuid());

            $api_url = Configuration::where('key','comment_api_url')->first();
            $api_key = Configuration::where('key','comment_api_key')->first();

            $response = Http::withHeaders([
                'api_key' => $api_key->value
            ])->post($api_url->value."v1/comments/save-player-comment", [
                'uuid'=> $uuid,
                'player_id'=> $request->player_id,
                'content'=> $comment,
                'language'=> $request->language,
                'user_id'=> $user->id,
                'username'=> $user->username,
                'display_name'=> $user->display_name,
                'profile_pic'=> $user->picture? $user->picture->file_path : null,
            ]);

            if ($response->json()['result'] =='ok') {
                //update comment count
                $news->update(['comment_count'=>$comment_count]);
                $message = 'Comment Saved';
            }else{
                $message = 'Comment failed';
            }
            return redirect()->back()->with(['message'=>$message]);
        }else{
            return back()->withErrors(['language' => 'Input only english letters and numbers']);
        }

    }

    //save users comments replies 
    public function saveReply(StorePlayerCommentReplyRequest $request)
    {
        if (!preg_match('/[^A-Za-z0-9 ]/', $request->comment)) 
        {
            $captcha_secret_key_v3= Configuration::where('key','captcha_secret_key_v3')->first();
            $recaptcha = $request->get('recaptcha');
            $captcha = captchaV3Validation($recaptcha, $captcha_secret_key_v3->value);
            if(!$captcha){
                    return back()->withErrors(['captcha' => 'ReCaptcha Error']);
            }

            $comment = Purifier::clean($request->comment);

            if (!$comment) {
                session()->flash('error','Invalid comment');
                return back();
            }
            $news = Player::findOrFail($request->player_id);
            $comment_count = $news->comment_count + 1;
            $user = User::where('id',Auth::id())->with('picture')->firstOrFail();
            $uuid= ((string) Str::uuid());

            $api_url = Configuration::where('key','comment_api_url')->first();
            $api_key = Configuration::where('key','comment_api_key')->first();

            $response = Http::withHeaders([
                'api_key' => $api_key->value
            ])->post($api_url->value."v1/comments/save-player-reply", [
                'uuid'=> $uuid,
                'parent_comment_id'=> $request->comment_id,
                'player_id'=> $request->player_id,
                'content'=> $comment,
                'language'=> $request->language,
                'user_id'=> $user->id,
                'username'=> $user->username,
                'display_name'=> $user->display_name,
                'profile_pic'=> $user->picture? $user->picture->file_path : null,
            ]);

            // $comment = PlayerComment::create([
            //     'uuid'=> $uuid,
            //     'parent_comment_id'=> $request->comment_id,
            //     'player_id'=> $request->player_id,
            //     'content'=> $comment,
            //     'language'=> $request->language,
            //     'user_id'=> $user->id,
            //     'username'=> $user->username,
            //     'display_name'=> $user->display_name,
            //     'profile_pic'=> $user->picture? $user->picture->file_path : null,
            // ]);
            if ($response->json()['result'] =='ok') {
                //update comment count
                $news->update(['comment_count'=>$comment_count]);
                $message = 'Reply Saved';
            }else{
                $message = 'Reply failed';
            }

            return redirect()->back()->with(['message'=>$message]);
        }else{
            return back()->withErrors(['language' => 'Input only english letters and numbers']);
        }
    }

    //report comment
    public function reportComment($id)
    {
        $policies= BanPolicy::where('type','comment')->get();
        
        return view('user.player.report-comment')->with(['policies'=> $policies, 'comment_id'=>$id]);
    }

    //create report
    public function createReport(ReportCommentRequest $request)
    {
        $api_url = Configuration::where('key','comment_api_url')->first();
        $api_key = Configuration::where('key','comment_api_key')->first();
        $response = Http::withHeaders([
            'api_key' => $api_key->value
        ])->post($api_url->value."v1/comments/report-player-comment", [
            'policy_id'=>$request->policy_id,
            'user_notes'=>$request->user_notes,
            'comment_id'=>$request->comment_id,
            'user_id'=>Auth::user()->username,
        ])->json();

        // $report = ReportedPlayerComment::create([
        //     'policy_id'=>$request->policy_id,
        //     'user_notes'=>$request->user_notes,
        //     'comment_id'=>$request->comment_id,
        //     'user_id'=>Auth::id(),
        // ]);
        
        if($response['result'] =='ok'){
            // $post = PlayerComment::findOrFail($request->comment_id);
            // $posts = $post->update([
            //     'status'=>'reported',
            // ]);
            $news = Player::findOrFail($response['player_id']);

            return redirect()->route('player.get.single', ['player_slug' => $news->url_slug.'-'.$news->id ])
                            ->with('message', 'Comment reported succesfully');
        }

    }
}
