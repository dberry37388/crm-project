<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

class Task extends Model
{
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

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isDone(): bool
    {
        return ! empty($this->completed_at);
    }
}
