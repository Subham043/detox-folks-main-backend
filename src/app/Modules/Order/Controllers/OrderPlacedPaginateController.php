<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Resources\OrderCollection;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Request;

class OrderPlacedPaginateController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get(Request $request){
        $data = $this->orderService->paginateLatestPlacedByUserPaymentCompleted($request->total ?? 10);
        return OrderCollection::collection($data);
    }

}