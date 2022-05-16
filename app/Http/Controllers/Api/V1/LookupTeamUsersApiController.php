<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\UserResource;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LookupTeamUsersApiController extends BaseApiController
{
    public function __invoke()
    {
//        $teamUsers = User::whereHas('teams', function (Builder $query) {
//            $user = Auth::user();
//
//            $query
//                ->where('teams.id', $user->current_team_id)
//                ->orWhere('teams.user_id', (int) $user->id);
//        })->get();

        $teamUsers = Auth::user()->currentTeam->users()->get();

        return UserResource::collection($teamUsers);
    }
}
