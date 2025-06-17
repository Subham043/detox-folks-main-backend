<?php

namespace App\Modules\HomePageBanner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HomePageBanner\Requests\HomePageBannerUpdateRequest;
use App\Modules\HomePageBanner\Services\HomePageBannerService;

class HomePageBannerUpdateController extends Controller
{
    private $bannerService;

    public function __construct(HomePageBannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function get($id){
        $data = $this->bannerService->getById($id);
        return view('admin.pages.banner.update', compact('data'));
    }

    public function post(HomePageBannerUpdateRequest $request, $id){
        $banner = $this->bannerService->getById($id);
        try {
            //code...
            $this->bannerService->update(
                $request->except(['desktop_image', 'mobile_image']),
                $banner
            );
            if($request->hasFile('desktop_image')){
                $this->bannerService->saveDesktopImage($banner);
            }
            if($request->hasFile('mobile_image')){
                $this->bannerService->saveMobileImage($banner);
            }
            return response()->json(["message" => "Home Page Banner updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
