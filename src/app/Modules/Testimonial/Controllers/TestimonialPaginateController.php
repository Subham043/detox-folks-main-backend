<?php

namespace App\Modules\Testimonial\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Testimonial\Services\TestimonialService;
use Illuminate\Http\Request;

class TestimonialPaginateController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->middleware('permission:list testimonials', ['only' => ['get']]);
        $this->testimonialService = $testimonialService;
    }

    public function get(Request $request){
        $data = $this->testimonialService->paginate($request->total ?? 10);
        return view('admin.pages.testimonial.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
