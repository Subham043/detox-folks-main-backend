<?php

namespace App\Modules\AboutPage\Main\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AboutPage\Main\Requests\MainRequest;
use App\Modules\AboutPage\Main\Services\MainService;

class AboutMainController extends Controller
{
    private $mainService;

    public function __construct(MainService $mainService)
    {
        $this->middleware('permission:edit about page content', ['only' => ['get','post']]);
        $this->mainService = $mainService;
    }

    public function get(){
        $data = $this->mainService->getBySlug('about_section');
        return view('admin.pages.about.main', compact('data'));
    }

    public function post(MainRequest $request){
        try {
            //code...
            $main = $this->mainService->createOrUpdate(
                $request->except('image'),
            );
            if($request->hasFile('image')){
                $this->mainService->saveImage($main);
            }
            return response()->json(["message" => "About Main updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
