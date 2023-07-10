<?php

namespace App\Modules\Counter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Counter\Services\CounterService;

class CounterDeleteController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->middleware('permission:delete counters', ['only' => ['get']]);
        $this->counterService = $counterService;
    }

    public function get($id){
        $counter = $this->counterService->getById($id);

        try {
            //code...
            $this->counterService->delete(
                $counter
            );
            return redirect()->back()->with('success_status', 'Counter deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
