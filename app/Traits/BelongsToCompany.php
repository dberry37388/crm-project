<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCompany
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
