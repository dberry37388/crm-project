<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\ActivityResourceCollection;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactActivitiesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return ActivityResourceCollection()
     */
    public function index(Request $request, Contact $contact)
    {
        return new ActivityResourceCollection(
            $contact
                ->activities()
                ->orderBy('updated_at', 'DESC')
                ->get()
        );
    }
}
