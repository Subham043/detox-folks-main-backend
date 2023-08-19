<?php

namespace App\Modules\BillingInformation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingInformation\Resources\BillingInformationCollection;
use App\Modules\BillingInformation\Services\BillingInformationService;

class BillingInformationDeleteController extends Controller
{
    private $billingInformationService;

    public function __construct(BillingInformationService $billingInformationService)
    {
        $this->billingInformationService = $billingInformationService;
    }

    public function delete($id){
        $billingInformation = $this->billingInformationService->getById($id);

        try {
            //code...
            $this->billingInformationService->delete(
                $billingInformation
            );
            return response()->json([
                'message' => "BillingInformation deleted successfully.",
                'billingInformation' => BillingInformationCollection::make($billingInformation),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }

}
