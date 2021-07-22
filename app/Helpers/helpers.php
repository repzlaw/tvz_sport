<?php

use App\Models\Team;
use App\Models\Player;
use App\Models\TeamFollower;
use App\Models\PlayerFollower;
use App\Models\CompetitionFollower;
use Illuminate\Support\Facades\Auth;

//follow or unfollow competition
function competitionFollowSystem($event_id)
{
    $user=Auth::user();
        if ($user->isFollowingCompetition($user->id, $event_id)){
            CompetitionFollower::where(['competition_id'=>$event_id, 'user_id'=>$user->id])->delete();
            return false;
        }

        $date = date("Y/m/d");
        $follow = CompetitionFollower::firstOrNew([
            'competition_id' => $event_id,
            'user_id' => $user->id,
        ]);
        $follow->follow_date = $date;
        $follow->save();
        return true;
}

//follow or unfollow player
function playerFollowSystem($player_id)
{
    $user=Auth::user();
        if ($user->isFollowingPlayer($user->id, $player_id)){
            PlayerFollower::where(['player_id'=>$player_id, 'user_id'=>$user->id])->delete();
            return false;
        }

        $date = date("Y/m/d");
        $follow = PlayerFollower::firstOrNew([
            'player_id' => $player_id,
            'user_id' => $user->id,
        ]);
        $follow->follow_date = $date;
        $follow->save();
        return true;
}

//follow or unfollow team
function teamFollowSystem($team_id)
{
    $user=Auth::user();
        if ($user->isFollowingTeam($user->id, $team_id)){
            TeamFollower::where(['team_id'=>$team_id, 'user_id'=>$user->id])->delete();
            return false;
        }

        $date = date("Y/m/d");
        $follow = TeamFollower::firstOrNew([
            'team_id' => $team_id,
            'user_id' => $user->id,
        ]);
        $follow->follow_date = $date;
        $follow->save();
        return true;
}

//process image function
function process_image($image)
{
    // Get filename with the extension
    $filenameWithExt = $image->getClientOriginalName();
    //get file name with the extension
    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    //get just extension
    $extension = $image->getClientOriginalExtension();
    
    //filename to store
    $fileNameToStore = $filename.'_'.time().'.'.$extension;

    return $fileNameToStore;
}

// fun to search player
function searchPlayer($query, $from)
{
        $q = $query;
        $output= ' ';
        if ($q != null) {
            $player = Player::where('full_name', 'like', "%$q%")->limit(5)->get();
            if (count($player)) {
                if ($from === 'editor') {
                    foreach ($player as $key => $p) {
                        $output .= "
                        <li class='list-group-item' onclick='selectPlayer($p)'>".$p->full_name."</li>
                        ";
                    }
                }elseif ($from === 'modal') {
                    foreach ($player as $key => $p) {
                        $output .= "
                        <li class='list-group-item' onclick='selectPlayerModal($p)'>".$p->full_name."</li>
                        ";
                    }
                }
            } else {
                $output = 'No Result';
            }
        } 
        return $output;
        
}

// fun to search team
function searchTeam($query, $from)
{
    $q = $query;
    $output= ' ';
    if ($q != null) {
        $team = Team::where('team_name', 'like', "%$q%")->limit(5)->get();
        if (count($team)) {
            if ($from === 'editor') {
                foreach ($team as $key => $p) {
                    $output .= "
                    <li class='list-group-item' onclick='selectteam($p)'>".$p->team_name."</li>
                    ";
                }
            }elseif ($from === 'modal') {
                foreach ($team as $key => $p) {
                    $output .= "
                    <li class='list-group-item' onclick='selectteamModal($p)'>".$p->team_name."</li>
                    ";
                }
            }
        } else {
            $output = 'No Result';
        }
    } 
    return $output;
        
}