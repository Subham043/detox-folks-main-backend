<?php

namespace App\Modules\Testimonial\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Testimonial\Requests\TestimonialUpdateRequest;
use App\Modules\Testimonial\Services\TestimonialService;

class TestimonialUpdateController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->middleware('permission:edit testimonials', ['only' => ['get','post']]);
        $this->testimonialService = $testimonialService;
    }

    public function get($id){
        $data = $this->testimonialService->getById($id);
        return view('admin.pages.testimonial.update', compact('data'));
    }

    public function post(TestimonialUpdateRequest $request, $id){
        $testimonial = $this->testimonialService->getById($id);
        try {
            //code...
            $this->testimonialService->update(
                $request->except('image'),
                $testimonial
            );
            if($request->hasFile('image')){
                $this->testimonialService->saveImage($testimonial);
            }
            return response()->json(["message" => "Testimonial updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
