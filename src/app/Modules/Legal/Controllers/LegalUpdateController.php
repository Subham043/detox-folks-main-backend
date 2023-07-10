<?php

namespace App\Modules\Legal\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Legal\Requests\LegalUpdateRequest;
use App\Modules\Legal\Services\LegalService;

class LegalUpdateController extends Controller
{
    private $legalService;

    public function __construct(LegalService $legalService)
    {
        $this->middleware('permission:edit legal pages', ['only' => ['get','post']]);
        $this->legalService = $legalService;
    }

    public function get($slug){
        $data = $this->legalService->getBySlug($slug);
        return view('admin.pages.legal.update', compact('data'));
    }

    public function post(LegalUpdateRequest $request, $slug){
        $legal = $this->legalService->getBySlug($slug);
        try {
            //code...
            $this->legalService->update(
                $request->validated(),
                $legal
            );
            return response()->json(["message" => "Legal Pages updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
