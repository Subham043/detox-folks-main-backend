<?php

namespace App\Modules\Settings\Controllers\ActivityLog;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogDetailController extends Controller
{
    private $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->middleware('permission:view activity log detail', ['only' => ['get']]);
        $this->activityLogService = $activityLogService;
    }

    public function get(Request $request, $id){
        $data = $this->activityLogService->getById($id);
        return view('admin.pages.setting.activity_log.detail', compact(['data']));
    }

}
