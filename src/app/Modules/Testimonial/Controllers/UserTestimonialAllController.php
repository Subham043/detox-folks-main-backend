<?php

namespace App\Modules\Testimonial\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Testimonial\Resources\UserTestimonialCollection;
use App\Modules\Testimonial\Services\TestimonialService;

class UserTestimonialAllController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function get(){
        $testimonial = $this->testimonialService->main_all();
        return response()->json([
            'message' => "Testimonial recieved successfully.",
            'testimonial' => UserTestimonialCollection::collection($testimonial),
        ], 200);
    }

}
