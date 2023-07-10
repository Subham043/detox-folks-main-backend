<?php

namespace App\Modules\Counter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Counter\Services\CounterService;
use Illuminate\Http\Request;

class CounterPaginateController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->middleware('permission:list counters', ['only' => ['get']]);
        $this->counterService = $counterService;
    }

    public function get(Request $request){
        $data = $this->counterService->paginate($request->total ?? 10);
        return view('admin.pages.counter.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
