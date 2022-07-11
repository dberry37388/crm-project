<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use App\Traits\AssignedToAUser;
use App\Traits\BelongsToTeam;
use App\Traits\CreatedByAUser;
use App\Traits\HasDeals;
use App\Traits\HasNotes;
use App\Traits\HasTasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Company extends Model
{
    use AssignedToAUser;
    use CreatedByAUser;
    use BelongsToTeam;
    use HasDeals;
    use HasFactory;
    use HasNotes;
    use HasTasks;
    use LogsActivity;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Company $company) {
            $company->contacts()->sync([]);
            $company->notes()->delete();
            $company->tasks()->delete();
            $company->deals()->detach();
            $company->activities()->delete();
        });
    }

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('companies')
            ->logOnly(['assigned_to.name', 'name', 'description', 'city', 'state', 'postal_code', 'number_of_employees', 'timezone', 'industry.name'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'companies_index';
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class)->withPivot(['assigned_to_id'])->withTimestamps();
    }
}
