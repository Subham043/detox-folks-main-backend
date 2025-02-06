<?php

namespace App\Modules\Tax\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tax\Requests\TaxCreateRequest;
use App\Modules\Tax\Services\TaxService;

class TaxCreateController extends Controller
{
    private $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function get(){
        return view('admin.pages.tax.create');
    }

    public function post(TaxCreateRequest $request){

        try {
            //code...
            $tax = $this->taxService->create(
                $request->validated()
            );
            return response()->json(["message" => "Tax created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
