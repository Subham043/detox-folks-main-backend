<?php

namespace App\Modules\Enquiry\OrderForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\OrderForm\Services\OrderFormService;
use Illuminate\Http\Request;

class OrderFormPaginateController extends Controller
{
    private $orderFormService;

    public function __construct(OrderFormService $orderFormService)
    {
        $this->orderFormService = $orderFormService;
    }

    public function get(Request $request){
        $data = $this->orderFormService->paginate($request->total ?? 10);
        return view('admin.pages.enquiry.order_form', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}