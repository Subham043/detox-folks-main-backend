<?php

namespace App\Modules\Settings\Controllers\General;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Requests\GeneralRequest;
use App\Modules\Settings\Services\GeneralService;

class GeneralController extends Controller
{
    private $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->middleware('permission:view general settings detail', ['only' => ['get','post']]);
        $this->generalService = $generalService;
    }

    public function get(){
        $data = $this->generalService->getById(1);
        return view('admin.pages.setting.general.index', compact('data'));
    }

    public function post(GeneralRequest $request){
        try {
            //code...
            $general = $this->generalService->createOrUpdate(
                $request->except(['website_logo', 'website_footer_logo', 'website_favicon']),
            );
            if($request->hasFile('website_logo')){
                $this->generalService->saveLogoImage($general);
            }
            if($request->hasFile('website_footer_logo')){
                $this->generalService->saveFooterLogoImage($general);
            }
            if($request->hasFile('website_favicon')){
                $this->generalService->saveFaviconImage($general);
            }
            return response()->json(["message" => "General settings updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
