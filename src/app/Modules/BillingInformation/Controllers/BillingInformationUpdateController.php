<?php

namespace App\Modules\BillingInformation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingInformation\Resources\BillingInformationCollection;
use App\Modules\BillingInformation\Requests\BillingInformationRequest;
use App\Modules\BillingInformation\Services\BillingInformationService;

class BillingInformationUpdateController extends Controller
{
    private $billingInformationService;

    public function __construct(BillingInformationService $billingInformationService)
    {
        $this->billingInformationService = $billingInformationService;
    }

    public function post(BillingInformationRequest $request, $id){
        $billingInformation = $this->billingInformationService->getById($id);
        try {
            //code...
            $billingInformation = $this->billingInformationService->update(
                $request->validated(),
                $billingInformation
            );
            return response()->json([
                'message' => "BillingInformation updated successfully.",
                'billingInformation' => BillingInformationCollection::make($billingInformation),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
