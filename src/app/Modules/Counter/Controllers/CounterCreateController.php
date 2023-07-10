<?php

namespace App\Modules\Counter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Counter\Requests\CounterCreateRequest;
use App\Modules\Counter\Services\CounterService;

class CounterCreateController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->middleware('permission:create counters', ['only' => ['get','post']]);
        $this->counterService = $counterService;
    }

    public function get(){
        return view('admin.pages.counter.create');
    }

    public function post(CounterCreateRequest $request){

        try {
            //code...
            $counter = $this->counterService->create(
                $request->validated()
            );
            return response()->json(["message" => "Counter created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
