<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use App\Traits\BelongsToCompany;
use App\Traits\CreatedByAUser;
use App\Traits\HasNotes;
use App\Traits\HasTasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Jetstream\HasTeams;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Deal extends Model
{
    use BelongsToCompany;
    use CreatedByAUser;
    use HasNotes;
    use HasFactory;
    use HasTasks;
    use HasTeams;
    use LogsActivity;

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(new TeamScope);

        self::deleting(function (Deal $deal) {
            $deal->contacts()->detach();
            $deal->companies()->detach();
            $deal->notes()->delete();
            $deal->tasks()->delete();
        });
    }

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'close_date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('deals')
            ->logOnly(['createdBy.name', 'ownedBy.name', 'type', 'state', 'priority', 'name', 'amount', 'close_date'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function searchableAs(): string
    {
        return 'deals_index';
    }

    public function ownedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owned_by_id');
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
