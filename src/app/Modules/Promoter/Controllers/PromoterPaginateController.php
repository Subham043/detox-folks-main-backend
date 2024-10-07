<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Promoter\Services\PromoterService;
use Illuminate\Http\Request;

class PromoterPaginateController extends Controller
{
    private $service;

    public function __construct(PromoterService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request){
        $data = $this->service->paginatePromoter($request->total ?? 10);
        return view('admin.pages.promoter.agent.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
