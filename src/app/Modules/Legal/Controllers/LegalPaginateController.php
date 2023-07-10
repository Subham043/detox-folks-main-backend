<?php

namespace App\Modules\Legal\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Legal\Services\LegalService;
use Illuminate\Http\Request;

class LegalPaginateController extends Controller
{
    private $legalService;

    public function __construct(LegalService $legalService)
    {
        $this->middleware('permission:list legal pages', ['only' => ['get']]);
        $this->legalService = $legalService;
    }

    public function get(Request $request){
        $data = $this->legalService->paginate($request->total ?? 10);
        return view('admin.pages.legal.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
