<?php

namespace App\Traits;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasDeals
{
    public function deals(): MorphToMany
    {
        return $this->morphToMany(Deal::class, 'dealable');
    }
}
