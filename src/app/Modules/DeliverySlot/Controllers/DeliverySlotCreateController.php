<?php

namespace App\Modules\DeliverySlot\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DeliverySlot\Requests\DeliverySlotCreateRequest;
use App\Modules\DeliverySlot\Services\DeliverySlotService;

class DeliverySlotCreateController extends Controller
{
    private $deliverySlotService;

    public function __construct(DeliverySlotService $deliverySlotService)
    {
        $this->deliverySlotService = $deliverySlotService;
    }

    public function get(){
        return view('admin.pages.delivery_slot.create');
    }

    public function post(DeliverySlotCreateRequest $request){

        try {
            //code...
            $deliverySlot = $this->deliverySlotService->create(
                $request->validated()
            );
            return response()->json(["message" => "Delivery Slot created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
