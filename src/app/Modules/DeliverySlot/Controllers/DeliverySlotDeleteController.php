<?php

namespace App\Modules\DeliverySlot\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DeliverySlot\Services\DeliverySlotService;

class DeliverySlotDeleteController extends Controller
{
    private $deliverySlotService;

    public function __construct(DeliverySlotService $deliverySlotService)
    {
        $this->deliverySlotService = $deliverySlotService;
    }

    public function get($id){
        $deliverySlot = $this->deliverySlotService->getById($id);

        try {
            //code...
            $this->deliverySlotService->delete(
                $deliverySlot
            );
            return redirect()->back()->with('success_status', 'Delivery Slot deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
