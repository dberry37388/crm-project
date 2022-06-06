<?php

namespace App\Models;

use App\Traits\AssignedToAUser;
use App\Traits\CreatedByAUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use AssignedToAUser;
    use CreatedByAUser;
    use HasFactory;
    use LogsActivity;

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
        'completed_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('tasks')
            ->logOnly(['assigned_to.name', 'task', 'notes', 'due_date', 'priority', 'created_by.name', 'completed_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function searchableAs(): string
    {
        return 'tasks_index';
    }

    public function taskable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isDone(): bool
    {
        return ! empty($this->completed_at);
    }
}
