<?php

namespace App\Modules\Tax\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tax\Requests\TaxRequest;
use App\Modules\Tax\Services\TaxService;

class TaxController extends Controller
{
    private $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->middleware('permission:edit tax', ['only' => ['get','post']]);
        $this->taxService = $taxService;
    }

    public function get(){
        $data = $this->taxService->getBySlug();
        return view('admin.pages.tax.index', compact('data'));
    }

    public function post(TaxRequest $request){
        try {
            //code...
            $tax = $this->taxService->createOrUpdate(
                $request->validated(),
            );
            return response()->json(["message" => "Tax updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
