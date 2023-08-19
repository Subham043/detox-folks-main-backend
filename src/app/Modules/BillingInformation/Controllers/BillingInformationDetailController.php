<?php

namespace App\Modules\BillingInformation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingInformation\Resources\BillingInformationCollection;
use App\Modules\BillingInformation\Services\BillingInformationService;

class BillingInformationDetailController extends Controller
{
    private $billingInformationService;

    public function __construct(BillingInformationService $billingInformationService)
    {
        $this->billingInformationService = $billingInformationService;
    }

    public function get($id){
        $billingInformation = $this->billingInformationService->getById($id);
        return response()->json([
            'message' => "BillingInformation recieved successfully.",
            'billingInformation' => BillingInformationCollection::make($billingInformation),
        ], 200);
    }
}
