<?php

namespace App\Modules\BillingInformation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingInformation\Requests\BillingInformationRequest;
use App\Modules\BillingInformation\Resources\BillingInformationCollection;
use App\Modules\BillingInformation\Services\BillingInformationService;

class BillingInformationCreateController extends Controller
{
    private $billingInformationService;

    public function __construct(BillingInformationService $billingInformationService)
    {
        $this->billingInformationService = $billingInformationService;
    }

    public function post(BillingInformationRequest $request){

        try {
            //code...
            $billingInformation = $this->billingInformationService->create(
                $request->validated()
            );
            return response()->json([
                'message' => "BillingInformation created successfully.",
                'billingInformation' => BillingInformationCollection::make($billingInformation),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
