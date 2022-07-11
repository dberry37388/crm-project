<?php

namespace App\Traits\Jetstream;

use App\Models\Team;

trait HasNoPersonalTeams
{

    /**
     * Determine if the user owns the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function ownsTeam($team): bool
    {
        // return $this->id == $team->user_id;
        return $this->id == optional($team)->user_id;
    }

    /**
     * Determine if the given team is the current team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function isCurrentTeam($team): bool
    {
        // return $team->id === $this->currentTeam->id;
        return optional($team)->id === $this->currentTeam->id;
    }

    /**
     * Get the user's "personal" team.
     *
     * @return Team
     */
    public function personalTeam()
    {
        return $this->ownedTeams()->first() ?? $this->teams()->first();
    }

    /**
     * Determine if the user is assigned to any teams.
     *
     * @return bool
     */
    public function belongsToAnyTeam(): bool
    {
        return (bool) optional($this->teams)->isNotEmpty();
    }

    /**
     * Determine if the user is a part of any team.
     *
     * @return bool
     */
    public function isMemberOfATeam(): bool
    {
        return (bool) ($this->teams()->count() || $this->ownedTeams()->count());
    }

}
