<?php

namespace App\Modules\Feature\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Feature\Requests\FeatureUpdateRequest;
use App\Modules\Feature\Services\FeatureService;

class FeatureUpdateController extends Controller
{
    private $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->middleware('permission:edit features', ['only' => ['get','post']]);
        $this->featureService = $featureService;
    }

    public function get($id){
        $data = $this->featureService->getById($id);
        return view('admin.pages.feature.update', compact('data'));
    }

    public function post(FeatureUpdateRequest $request, $id){
        $feature = $this->featureService->getById($id);
        try {
            //code...
            $this->featureService->update(
                $request->except('image'),
                $feature
            );
            if($request->hasFile('image')){
                $this->featureService->saveImage($feature);
            }
            return response()->json(["message" => "Feature updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
