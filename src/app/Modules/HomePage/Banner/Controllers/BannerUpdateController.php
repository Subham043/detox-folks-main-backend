<?php

namespace App\Modules\HomePage\Banner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HomePage\Banner\Requests\BannerUpdateRequest;
use App\Modules\HomePage\Banner\Services\BannerService;

class BannerUpdateController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->middleware('permission:edit home page content', ['only' => ['get','post']]);
        $this->bannerService = $bannerService;
    }

    public function get($id){
        $data = $this->bannerService->getById($id);
        return view('admin.pages.home_page.banner.update', compact('data'));
    }

    public function post(BannerUpdateRequest $request, $id){
        $banner = $this->bannerService->getById($id);
        try {
            //code...
            $this->bannerService->update(
                $request->except('banner_image'),
                $banner
            );
            if($request->hasFile('banner_image')){
                $this->bannerService->saveImage($banner);
            }
            return response()->json(["message" => "Banner updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
