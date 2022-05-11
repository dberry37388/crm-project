<?php

namespace App\Traits;

use App\Models\Deal;
use App\Models\Note;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasDeals
{
    public function deals(): MorphMany
    {
        return $this->morphToMany(Deal::class, 'dealable');
    }
}
