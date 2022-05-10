<?php

namespace App\Traits;

use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTasks
{
    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'taskable');
    }
}
