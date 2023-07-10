<?php

namespace App\Modules\Counter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Counter\Requests\CounterUpdateRequest;
use App\Modules\Counter\Services\CounterService;

class CounterUpdateController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->middleware('permission:edit counters', ['only' => ['get','post']]);
        $this->counterService = $counterService;
    }

    public function get($id){
        $data = $this->counterService->getById($id);
        return view('admin.pages.counter.update', compact('data'));
    }

    public function post(CounterUpdateRequest $request, $id){
        $counter = $this->counterService->getById($id);
        try {
            //code...
            $this->counterService->update(
                $request->validated(),
                $counter
            );
            return response()->json(["message" => "Counter updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
