<?php

namespace App\Modules\BillingAddress\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BillingAddress\Requests\BillingAddressRequest;
use App\Modules\BillingAddress\Resources\BillingAddressCollection;
use App\Modules\BillingAddress\Services\BillingAddressService;

class BillingAddressCreateController extends Controller
{
    private $billingAddressService;

    public function __construct(BillingAddressService $billingAddressService)
    {
        $this->billingAddressService = $billingAddressService;
    }

    public function post(BillingAddressRequest $request){

        try {
            //code...
            $billingAddress = $this->billingAddressService->create(
                $request->validated()
            );
            return response()->json([
                'message' => "BillingAddress created successfully.",
                'billingAddress' => BillingAddressCollection::make($billingAddress),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
