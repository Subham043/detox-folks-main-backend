<?php

namespace App\Modules\Enquiry\OrderForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\OrderForm\Services\OrderFormService;

class OrderFormDeleteController extends Controller
{
    private $orderFormService;

    public function __construct(OrderFormService $orderFormService)
    {
        $this->orderFormService = $orderFormService;
    }

    public function get($id){
        $orderForm = $this->orderFormService->getById($id);

        try {
            //code...
            $this->orderFormService->delete(
                $orderForm
            );
            return redirect()->back()->with('success_status', 'Order Form deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}