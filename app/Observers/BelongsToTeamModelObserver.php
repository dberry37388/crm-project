<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class BelongsToTeamModelObserver
{
    public function saving($model): void
    {
        if (empty($model->team_id) && Auth::check()) {
            $model->team_id = Auth::user()->current_team_id;
        }
    }
}
