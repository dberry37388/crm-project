<?php

namespace App\Http\Controllers\Frontend\Deals;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\DealResource;
use App\Models\Deal;
use Inertia\Inertia;

class ShowDealController extends Controller
{
    public function __invoke(int $deal)
    {
        $deal = Deal::with(['createdBy', 'ownedBy'])->findOrFail($deal);

        return Inertia::render('Deals/ShowDeal', [
            'deal' => new DealResource($deal)
        ]);
    }
}
