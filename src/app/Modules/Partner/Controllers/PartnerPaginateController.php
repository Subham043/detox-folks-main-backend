<?php

namespace App\Modules\Partner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Partner\Services\PartnerService;
use Illuminate\Http\Request;

class PartnerPaginateController extends Controller
{
    private $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->middleware('permission:list partners', ['only' => ['get']]);
        $this->partnerService = $partnerService;
    }

    public function get(Request $request){
        $data = $this->partnerService->paginate($request->total ?? 10);
        return view('admin.pages.partner.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
