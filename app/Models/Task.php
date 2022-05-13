<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use App\Traits\AssignedToAUser;
use App\Traits\CreatedByAUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

class Task extends Model
{
    use AssignedToAUser;
    use CreatedByAUser;
    use HasFactory;
    use Searchable;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'taskable_id',
        'taskable_type'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date',
        'completed_at'
    ];

    public function searchableAs(): string
    {
        return 'tasks_index';
    }

    public function noteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isDone(): bool
    {
        return ! empty($this->completed_at);
    }
}
