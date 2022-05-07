<?php

namespace App\Http\Controllers\Frontend\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListContactsController extends Controller
{
    public function __invoke(Request $request)
    {
        $contacts = Contact::where('team_id', Auth::user()->current_team_id)
            ->with(['createdBy', 'assignedTo', 'companies'])
            ->orderBy('first_name', 'asc')
            ->paginate($request->get('per_page', 25));

        return Inertia::render('Contacts/ListContacts', [
            'contacts' => ContactResource::collection($contacts),
        ]);
    }
}
