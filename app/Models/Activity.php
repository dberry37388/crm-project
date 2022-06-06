<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use Spatie\Activitylog\Models\Activity as SpatieActivityModel;

class Activity extends SpatieActivityModel
{
    use BelongsToTeam;
}
