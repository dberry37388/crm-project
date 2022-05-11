<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use App\Traits\CreatedByAUser;
use App\Traits\HasNotes;
use App\Traits\HasTasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Jetstream\HasTeams;
use Laravel\Scout\Searchable;

class Deal extends Model
{
    use BelongsToCompany;
    use CreatedByAUser;
    use HasNotes;
    use HasFactory;
    use HasTasks;
    use HasTeams;
    use Searchable;

    protected $dates = [
        'updated_at',
        'created_at',
        'close_date',
    ];

    public function searchableAs(): string
    {
        return 'deals_index';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all the posts that are assigned this tag.
     */
    public function companies(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Company::class, 'dealable');
    }

    /**
     * Get all the videos that are assigned this tag.
     */
    public function contacts(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(Contact::class, 'dealable');
    }
}
