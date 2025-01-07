<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Exports\OrderExport;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderAdminExcelController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get(Request $request){
        $data = $this->orderService->excelForAdmin();
        return Excel::download(new OrderExport($data), 'orders.xlsx');
    }

}
