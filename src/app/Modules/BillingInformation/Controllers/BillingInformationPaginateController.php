<?php

namespace App\Modules\BillingInformation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingInformation\Resources\BillingInformationCollection;
use App\Modules\BillingInformation\Services\BillingInformationService;
use Illuminate\Http\Request;

class BillingInformationPaginateController extends Controller
{
    private $billingInformationService;

    public function __construct(BillingInformationService $billingInformationService)
    {
        $this->billingInformationService = $billingInformationService;
    }

    public function get(Request $request){
        $data = $this->billingInformationService->paginate($request->total ?? 10);
        return BillingInformationCollection::collection($data);
    }

}
