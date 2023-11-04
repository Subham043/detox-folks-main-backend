<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Request;

class PhonepeController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function post(Request $request){
        $url = $this->orderService->phone_pe_response($request->all());
        return redirect()->away($url);
    }
}
