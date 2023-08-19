<?php

namespace App\Modules\BillingAddress\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingAddress\Resources\BillingAddressCollection;
use App\Modules\BillingAddress\Services\BillingAddressService;
use Illuminate\Http\Request;

class BillingAddressPaginateController extends Controller
{
    private $billingAddressService;

    public function __construct(BillingAddressService $billingAddressService)
    {
        $this->billingAddressService = $billingAddressService;
    }

    public function get(Request $request){
        $data = $this->billingAddressService->paginate($request->total ?? 10);
        return BillingAddressCollection::collection($data);
    }

}
