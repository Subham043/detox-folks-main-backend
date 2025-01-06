<?php

namespace App\Modules\DeliverySlot\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DeliverySlot\Services\DeliverySlotService;
use Illuminate\Http\Request;

class DeliverySlotPaginateController extends Controller
{
    private $deliverySlotService;

    public function __construct(DeliverySlotService $deliverySlotService)
    {
        $this->deliverySlotService = $deliverySlotService;
    }

    public function get(Request $request){
        $data = $this->deliverySlotService->paginate($request->total ?? 10);
        return view('admin.pages.delivery_slot.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
