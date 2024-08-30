<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Order\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderInvoicePdfController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function get($id){
        $order = $this->orderService->getById($id);
        $fileName = str()->uuid();
        $data = [
            'order' => $order
        ];
        $pdf = Pdf::loadView('pdf.invoice_2', $data)->setPaper('a4', 'potrait');
        $pdf->save(storage_path('app/public/reports/').$fileName.'.pdf');
        return response()->json(['path' => route('downaload_invoice_customer', $fileName.'.pdf')]);
    }
}
