<?php

namespace App\Models;

use App\Traits\AssignedToAUser;
use App\Traits\BelongsToTeam;
use App\Traits\CreatedByAUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Company extends Model
{
    use AssignedToAUser;
    use CreatedByAUser;
    use BelongsToTeam;
    use HasFactory;
    use Searchable;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

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
}
