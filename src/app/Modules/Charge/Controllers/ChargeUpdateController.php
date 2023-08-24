<?php

namespace App\Modules\Charge\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Charge\Requests\ChargeUpdateRequest;
use App\Modules\Charge\Services\ChargeService;

class ChargeUpdateController extends Controller
{
    private $chargeService;

    public function __construct(ChargeService $chargeService)
    {
        $this->middleware('permission:edit charges', ['only' => ['get','post']]);
        $this->chargeService = $chargeService;
    }

    public function get($id){
        $data = $this->chargeService->getById($id);
        return view('admin.pages.charge.update', compact('data'));
    }

    public function post(ChargeUpdateRequest $request, $id){
        $charge = $this->chargeService->getById($id);
        try {
            //code...
            $this->chargeService->update(
                $request->validated(),
                $charge
            );
            return response()->json(["message" => "Charge updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
