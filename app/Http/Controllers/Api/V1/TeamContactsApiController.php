<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Http\Resources\Api\V1\ContactResourceCollection;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

class TeamContactsApiController extends BaseApiController
{
    /**
     * @param Request $request
     *
     * @return ContactResourceCollection
     */
    public function index(Request $request)
    {
        return new ContactResourceCollection(
            Contact::where(function($query) use($request) {
                return $query->where('first_name', 'like', "%{$request->get('query')}")
                    ->orWhere('last_name', 'like', "%{$request->get('query')}")
                    ->orWhere('email', 'like', "%{$request->get('query')}");
            })
                ->where('team_id', Auth::user()->current_team_id)
                ->get()
        );
    }
}
