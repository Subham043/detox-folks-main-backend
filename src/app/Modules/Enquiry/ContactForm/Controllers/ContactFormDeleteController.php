<?php

namespace App\Modules\Enquiry\ContactForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\ContactForm\Services\ContactFormService;

class ContactFormDeleteController extends Controller
{
    private $contactFormService;

    public function __construct(ContactFormService $contactFormService)
    {
        $this->middleware('permission:delete enquiries', ['only' => ['get']]);
        $this->contactFormService = $contactFormService;
    }

    public function get($id){
        $contact = $this->contactFormService->getById($id);

        try {
            //code...
            $this->contactFormService->delete(
                $contact
            );
            return redirect()->back()->with('success_status', 'Contact Form deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
