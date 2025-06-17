<?php

namespace App\Modules\HomePageBanner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HomePageBanner\Resources\UserHomePageBannerCollection;
use App\Modules\HomePageBanner\Services\HomePageBannerService;

class UserHomePageBannerAllController extends Controller
{
    private $bannerService;

    public function __construct(HomePageBannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function get(){
        $banner = $this->bannerService->main_all();
        return response()->json([
            'message' => "Home Page Banner recieved successfully.",
            'banner' => UserHomePageBannerCollection::collection($banner),
        ], 200);
    }

}
