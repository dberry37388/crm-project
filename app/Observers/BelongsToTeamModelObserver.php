<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class BelongsToTeamModelObserver
{
    public function saving($model): void
    {
        $model->team_id = Auth::user()->current_team_id;
    }
}
