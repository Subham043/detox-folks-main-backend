<?php

namespace App\Modules\BillingAddress\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingAddress\Resources\BillingAddressCollection;
use App\Modules\BillingAddress\Requests\BillingAddressRequest;
use App\Modules\BillingAddress\Services\BillingAddressService;

class BillingAddressUpdateController extends Controller
{
    private $billingAddressService;

    public function __construct(BillingAddressService $billingAddressService)
    {
        $this->billingAddressService = $billingAddressService;
    }

    public function post(BillingAddressRequest $request, $id){
        $billingAddress = $this->billingAddressService->getById($id);
        try {
            //code...
            $billingAddress = $this->billingAddressService->update(
                $request->validated(),
                $billingAddress
            );
            return response()->json([
                'message' => "BillingAddress updated successfully.",
                'billingAddress' => BillingAddressCollection::make($billingAddress),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
