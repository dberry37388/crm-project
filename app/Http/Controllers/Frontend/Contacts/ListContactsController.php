<?php

namespace App\Http\Controllers\Frontend\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ContactResource;
use App\Models\Contact;
use App\QueryBuilder\Sorts\RelatedSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ListContactsController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Contacts/ListContacts');
    }
}
