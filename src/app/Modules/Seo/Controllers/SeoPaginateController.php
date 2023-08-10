<?php

namespace App\Modules\Seo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seo\Services\SeoService;
use Illuminate\Http\Request;

class SeoPaginateController extends Controller
{
    private $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->middleware('permission:list pages seo', ['only' => ['get']]);
        $this->seoService = $seoService;
    }

    public function get(Request $request){
        $data = $this->seoService->paginate($request->total ?? 10);
        return view('admin.pages.seo.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
