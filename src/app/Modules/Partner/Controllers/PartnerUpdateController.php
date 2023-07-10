<?php

namespace App\Modules\Partner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Partner\Requests\PartnerUpdateRequest;
use App\Modules\Partner\Services\PartnerService;

class PartnerUpdateController extends Controller
{
    private $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->middleware('permission:edit partners', ['only' => ['get','post']]);
        $this->partnerService = $partnerService;
    }

    public function get($id){
        $data = $this->partnerService->getById($id);
        return view('admin.pages.partner.update', compact('data'));
    }

    public function post(PartnerUpdateRequest $request, $id){
        $partner = $this->partnerService->getById($id);
        try {
            //code...
            $this->partnerService->update(
                $request->except('image'),
                $partner
            );
            if($request->hasFile('image')){
                $this->partnerService->saveImage($partner);
            }
            return response()->json(["message" => "Partner updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
