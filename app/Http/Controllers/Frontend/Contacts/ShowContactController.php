<?php

namespace App\Http\Controllers\Frontend\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Http\Resources\Api\V1\ContactResource;
use App\Models\Company;
use App\Models\Contact;
use Inertia\Inertia;

class ShowContactController extends Controller
{
    public function __invoke(int $contact)
    {
        $contact = Contact::with(['createdBy', 'assignedTo'])->findOrFail($contact);

        return Inertia::render('Contacts/ShowContact', [
            'contact' => new ContactResource($contact)
        ]);
    }
}
