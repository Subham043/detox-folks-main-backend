<?php

namespace App\Modules\DeliverySlot\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DeliverySlot\Resources\UserDeliverySlotCollection;
use App\Modules\DeliverySlot\Services\DeliverySlotService;

class UserDeliverySlotAllController extends Controller
{
    private $deliverySlotService;

    public function __construct(DeliverySlotService $deliverySlotService)
    {
        $this->deliverySlotService = $deliverySlotService;
    }

    public function get(){
        $deliverySlot = $this->deliverySlotService->main_all();
        return response()->json([
            'message' => "Delivery Slot recieved successfully.",
            'delivery_slot' => UserDeliverySlotCollection::collection($deliverySlot),
        ], 200);
    }

}
