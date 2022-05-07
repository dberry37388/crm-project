<?php

namespace App\Models;

use App\Traits\AssignedToAUser;
use App\Traits\BelongsToCompany;
use App\Traits\CreatedByAUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Contact extends Model
{
    use AssignedToAUser;
    use BelongsToCompany;
    use CreatedByAUser;
    use HasFactory;
    use Searchable;

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
}
