<?php

namespace App\Modules\Enquiry\ContactForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\ContactForm\Services\ContactFormService;
use Illuminate\Http\Request;

class ContactFormPaginateController extends Controller
{
    private $contactFormService;

    public function __construct(ContactFormService $contactFormService)
    {
        $this->middleware('permission:list enquiries', ['only' => ['get']]);
        $this->contactFormService = $contactFormService;
    }

    public function get(Request $request){
        $data = $this->contactFormService->paginate($request->total ?? 10);
        return view('admin.pages.enquiry.contact_form', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
