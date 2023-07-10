<?php

namespace App\Modules\Testimonial\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Testimonial\Requests\TestimonialCreateRequest;
use App\Modules\Testimonial\Services\TestimonialService;

class TestimonialCreateController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->middleware('permission:create testimonials', ['only' => ['get','post']]);
        $this->testimonialService = $testimonialService;
    }

    public function get(){
        return view('admin.pages.testimonial.create');
    }

    public function post(TestimonialCreateRequest $request){

        try {
            //code...
            $testimonial = $this->testimonialService->create(
                $request->except('image')
            );
            if($request->hasFile('image')){
                $this->testimonialService->saveImage($testimonial);
            }
            return response()->json(["message" => "Testimonial created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
