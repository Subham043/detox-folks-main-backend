<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderAdminInvoicePdfController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get($id){
        $order = $this->orderService->getByIdForAdmin($id);
        $fileName = str()->uuid();
        $data = [
            'order' => $order
        ];
        $pdf = Pdf::loadView('pdf.invoice', $data)->setPaper('a4', 'potrait');
        // // // $pdf->save(storage_path('app/public/reports/').$fileName.'.pdf');
        return $pdf->download($fileName.'.pdf');
        // return view('pdf.invoice', compact(['order']))
        // ->with([
        //     'order_statuses' => $order->statuses->pluck('status')->toArray(),
        // ]);
    }
}