<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserExcelController extends Controller
{

    public function get(){
        return Excel::download(new UserExport, 'users.xlsx');
    }

}
