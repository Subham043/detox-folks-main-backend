<?php

namespace App\Modules\Enquiry\ContactForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\ContactForm\Requests\ContactFormRequest;
use App\Modules\Enquiry\ContactForm\Resources\ContactFormCollection;
use App\Modules\Enquiry\ContactForm\Services\ContactFormService;

class ContactFormCreateController extends Controller
{
    private $contactFormService;

    public function __construct(ContactFormService $contactFormService)
    {
        $this->contactFormService = $contactFormService;
    }

    public function post(ContactFormRequest $request){

        try {
            //code...
            $contactForm = $this->contactFormService->create(
                [
                    ...$request->validated(),
                ]
            );

            return response()->json([
                'message' => "Enquiry created successfully.",
                'contactForm' => ContactFormCollection::make($contactForm),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Something went wrong. Please try again",
            ], 400);
        }

    }
}
