<?php

namespace App\Modules\Charge\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Charge\Services\ChargeService;
use Illuminate\Http\Request;

class ChargePaginateController extends Controller
{
    private $chargeService;

    public function __construct(ChargeService $chargeService)
    {
        $this->chargeService = $chargeService;
    }

    public function get(Request $request){
        $data = $this->chargeService->paginate($request->total ?? 10);
        return view('admin.pages.charge.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}