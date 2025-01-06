<?php

namespace App\Modules\DeliverySlot\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DeliverySlot\Requests\DeliverySlotUpdateRequest;
use App\Modules\DeliverySlot\Services\DeliverySlotService;

class DeliverySlotUpdateController extends Controller
{
    private $deliverySlotService;

    public function __construct(DeliverySlotService $deliverySlotService)
    {
        $this->deliverySlotService = $deliverySlotService;
    }

    public function get($id){
        $data = $this->deliverySlotService->getById($id);
        return view('admin.pages.delivery_slot.update', compact('data'));
    }

    public function post(DeliverySlotUpdateRequest $request, $id){
        $deliverySlot = $this->deliverySlotService->getById($id);
        try {
            //code...
            $this->deliverySlotService->update(
                $request->validated(),
                $deliverySlot
            );
            return response()->json(["message" => "Delivery Slot updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
