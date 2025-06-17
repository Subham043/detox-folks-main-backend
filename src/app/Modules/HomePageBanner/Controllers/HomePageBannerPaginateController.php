<?php

namespace App\Modules\HomePageBanner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HomePageBanner\Services\HomePageBannerService;
use Illuminate\Http\Request;

class HomePageBannerPaginateController extends Controller
{
    private $bannerService;

    public function __construct(HomePageBannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function get(Request $request){
        $data = $this->bannerService->paginate($request->total ?? 10);
        return view('admin.pages.banner.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
