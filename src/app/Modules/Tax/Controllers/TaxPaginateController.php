<?php

namespace App\Modules\Tax\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tax\Services\TaxService;
use Illuminate\Http\Request;

class TaxPaginateController extends Controller
{
    private $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function get(Request $request){
        $data = $this->taxService->paginate($request->total ?? 10);
        return view('admin.pages.tax.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
