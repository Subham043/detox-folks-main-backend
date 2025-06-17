<?php

namespace App\Modules\HomePageBanner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HomePageBanner\Services\HomePageBannerService;

class HomePageBannerDeleteController extends Controller
{
    private $bannerService;

    public function __construct(HomePageBannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function get($id){
        $banner = $this->bannerService->getById($id);

        try {
            //code...
            $this->bannerService->delete(
                $banner
            );
            return redirect()->back()->with('success_status', 'Home Page Banner deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
