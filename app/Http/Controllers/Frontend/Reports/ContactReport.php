<?php

namespace App\Http\Controllers\Frontend\Reports;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactReport extends Controller
{
    public function __invoke()
    {
        $contacts = Contact::orderBy('first_name')
            ->orderBy('last_name')
            ->get();


    }
}
