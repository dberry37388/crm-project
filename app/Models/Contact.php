<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use App\Traits\AssignedToAUser;
use App\Traits\BelongsToCompany;
use App\Traits\CreatedByAUser;
use App\Traits\HasDeals;
use App\Traits\HasNotes;
use App\Traits\HasTasks;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use AssignedToAUser;
    use BelongsToCompany;
    use CreatedByAUser;
    use HasDeals;
    use HasFactory;
    use HasNotes;
    use HasTasks;

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(new TeamScope);

        self::deleting(function (Contact $contact) {
            $contact->companies()->detach();
            $contact->notes()->delete();
            $contact->tasks()->delete();
            $contact->deals()->detach();
        });
    }

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'contacts_index';
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->withPivot(['assigned_to_id'])->withTimestamps();
    }

    public function scopeSearchByName(Builder $query, $term): Builder
    {
        return $query->where('first_name', 'LIKE', "%{$term}%")
            ->orWhere('last_name', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('phone_number', 'LIKE', "%{$term}%")
            ->orWhere('mobile_number', 'LIKE', "%{$term}%");
    }
}
