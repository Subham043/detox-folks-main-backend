<?php

namespace App\Modules\Partner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Partner\Requests\PartnerCreateRequest;
use App\Modules\Partner\Services\PartnerService;

class PartnerCreateController extends Controller
{
    private $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->middleware('permission:create partners', ['only' => ['get','post']]);
        $this->partnerService = $partnerService;
    }

    public function get(){
        return view('admin.pages.partner.create');
    }

    public function post(PartnerCreateRequest $request){

        try {
            //code...
            $partner = $this->partnerService->create(
                $request->except('image')
            );
            if($request->hasFile('image')){
                $this->partnerService->saveImage($partner);
            }
            return response()->json(["message" => "Partner created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
