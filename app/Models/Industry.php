<?php

namespace App\Models;

use App\Traits\BelongsToTeam;
use App\Traits\CreatedByAUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Industry extends Model
{
    use BelongsToTeam;
    use CreatedByAUser;
    use HasFactory;
    use Searchable;

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
}