<?php

namespace App\Modules\Charge\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Charge\Requests\ChargeCreateRequest;
use App\Modules\Charge\Services\ChargeService;

class ChargeCreateController extends Controller
{
    private $chargeService;

    public function __construct(ChargeService $chargeService)
    {
        $this->middleware('permission:create charges', ['only' => ['get','post']]);
        $this->chargeService = $chargeService;
    }

    public function get(){
        return view('admin.pages.charge.create');
    }

    public function post(ChargeCreateRequest $request){

        try {
            //code...
            $charge = $this->chargeService->create(
                $request->validated()
            );
            return response()->json(["message" => "Charge created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
