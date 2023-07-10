<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function get(Request $request){
        $health = $this->dashboardService->getAppHealthResult($request);
        $lastRanAt  = new Carbon($health?->finishedAt);
        return view('admin.pages.dashboard.index', compact(['health', 'lastRanAt']));
    }
}
