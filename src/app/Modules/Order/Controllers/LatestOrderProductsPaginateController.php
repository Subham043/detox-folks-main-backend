<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Resources\LatestOrderProductCollection;
use App\Modules\Order\Resources\OrderCollection;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Request;

class LatestOrderProductsPaginateController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get(Request $request){
        $data = $this->orderService->paginateOrderProducts($request->total ?? 10);
        return LatestOrderProductCollection::collection($data);
    }

}
