<?php

namespace App\Modules\BillingAddress\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingAddress\Resources\BillingAddressCollection;
use App\Modules\BillingAddress\Services\BillingAddressService;

class BillingAddressDetailController extends Controller
{
    private $billingAddressService;

    public function __construct(BillingAddressService $billingAddressService)
    {
        $this->billingAddressService = $billingAddressService;
    }

    public function get($id){
        $billingAddress = $this->billingAddressService->getById($id);
        return response()->json([
            'message' => "BillingAddress recieved successfully.",
            'billingAddress' => BillingAddressCollection::make($billingAddress),
        ], 200);
    }
}
