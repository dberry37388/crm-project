<?php

namespace App\Traits;

use App\Models\Scopes\TeamScope;
use App\Models\Team;
use App\Observers\BelongsToTeamModelObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::addGlobalScope(new TeamScope);
        static::observe(new BelongsToTeamModelObserver);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
