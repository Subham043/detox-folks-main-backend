<?php

namespace App\Modules\HomePage\Banner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HomePage\Banner\Services\BannerService;
use Illuminate\Http\Request;

class BannerPaginateController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->middleware('permission:list home page content', ['only' => ['get']]);
        $this->bannerService = $bannerService;
    }

    public function get(Request $request){
        $data = $this->bannerService->paginate($request->total ?? 10);
        return view('admin.pages.home_page.banner.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
