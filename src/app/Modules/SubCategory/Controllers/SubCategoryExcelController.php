<?php

namespace App\Modules\SubCategory\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SubCategory\Exports\SubCategoryExport;
use Maatwebsite\Excel\Facades\Excel;

class SubCategoryExcelController extends Controller
{

    public function get(){
        return Excel::download(new SubCategoryExport, 'sub_categories.xlsx');
    }

}
