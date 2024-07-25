<?php

namespace App\Modules\Enquiry\OrderForm\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Enquiry\OrderForm\Exports\OrderFormExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderFormExcelController extends Controller
{

    public function get(){
        return Excel::download(new OrderFormExport, 'order_form.xlsx');
    }

}