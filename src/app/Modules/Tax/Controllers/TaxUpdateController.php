<?php

namespace App\Modules\Tax\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tax\Requests\TaxUpdateRequest;
use App\Modules\Tax\Services\TaxService;

class TaxUpdateController extends Controller
{
    private $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function get($id){
        $data = $this->taxService->getById($id);
        return view('admin.pages.tax.update', compact('data'));
    }

    public function post(TaxUpdateRequest $request, $id){
        $tax = $this->taxService->getById($id);
        try {
            //code...
            $this->taxService->update(
                $request->validated(),
                $tax
            );
            return response()->json(["message" => "Tax updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
