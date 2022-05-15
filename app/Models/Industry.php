<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use App\Traits\BelongsToTeam;
use App\Traits\CreatedByAUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    use BelongsToTeam;
    use CreatedByAUser;
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(new TeamScope);
    }

    protected $fillable = [
        'team_id',
        'created_by_id',
        'name'
    ];

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'industries_index';
    }

    public static function createDefaultsForTeam($team)
    {
        foreach (config('defaults.industries') as $industry) {
            Industry::create([
                'team_id' => $team->id,
                'created_by_id' => $team->user_id,
                'name' => $industry
            ]);
        }
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
