<?php

namespace App\Listeners\TeamCreated;

use App\Models\Industry;
use \Laravel\Jetstream\Events\TeamCreated;

class CreateDefaultIndustries
{
    /**
     * Handle the event.
     *
     * @param TeamCreated $event
     * @return void
     */
    public function handle(TeamCreated $event): void
    {
        Industry::createDefaultsForTeam($event->team);
    }
}
