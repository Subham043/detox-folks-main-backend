<?php

namespace App\Modules\Settings\Controllers\ActivityLog;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogPaginateController extends Controller
{
    private $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->middleware('permission:list activity logs', ['only' => ['get']]);
        $this->activityLogService = $activityLogService;
    }

    public function get(Request $request){
        $data = $this->activityLogService->paginate($request->total ?? 10);
        return view('admin.pages.setting.activity_log.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
