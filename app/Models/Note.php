<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

class Note extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [
        'noteable_type',
        'noteable_id',
        'id',
        'created_at',
        'updated_at'
    ];

    public function searchableAs(): string
    {
        return 'notes_index';
    }

    public function noteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
