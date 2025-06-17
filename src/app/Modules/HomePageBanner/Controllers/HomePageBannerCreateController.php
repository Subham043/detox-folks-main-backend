<?php

namespace App\Modules\HomePageBanner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HomePageBanner\Requests\HomePageBannerCreateRequest;
use App\Modules\HomePageBanner\Services\HomePageBannerService;

class HomePageBannerCreateController extends Controller
{
    private $bannerService;

    public function __construct(HomePageBannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function get(){
        return view('admin.pages.banner.create');
    }

    public function post(HomePageBannerCreateRequest $request){

        try {
            //code...
            $banner = $this->bannerService->create(
                $request->except(['desktop_image', 'mobile_image'])
            );
            if($request->hasFile('desktop_image')){
                $this->bannerService->saveDesktopImage($banner);
            }
            if($request->hasFile('mobile_image')){
                $this->bannerService->saveMobileImage($banner);
            }
            return response()->json(["message" => "Home Page Banner created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
