<?php

namespace App\Modules\Counter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Counter\Resources\UserCounterCollection;
use App\Modules\Counter\Services\CounterService;

class UserCounterAllController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

    public function get(){
        $counter = $this->counterService->main_all();
        return response()->json([
            'message' => "Counter recieved successfully.",
            'counter' => UserCounterCollection::collection($counter),
        ], 200);
    }

}
