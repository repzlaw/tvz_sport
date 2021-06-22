<?php

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