<?php

namespace App\Modules\Seo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seo\Requests\SeoRequest;
use App\Modules\Seo\Services\SeoService;

class SeoUpdateController extends Controller
{
    private $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->middleware('permission:edit pages seo', ['only' => ['get','post']]);
        $this->seoService = $seoService;
    }

    public function get($slug){
        $data = $this->seoService->getBySlug($slug);
        return view('admin.pages.seo.update', compact('data'));
    }

    public function post(SeoRequest $request, $slug){
        $seo = $this->seoService->getBySlug($slug);
        try {
            //code...
            $this->seoService->update(
                $request->except('image'),
                $seo
            );
            return response()->json(["message" => "Seo updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
