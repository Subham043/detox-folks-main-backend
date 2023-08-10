<?php

namespace App\Modules\Feature\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Feature\Resources\UserFeatureCollection;
use App\Modules\Feature\Services\FeatureService;

class UserFeatureAllController extends Controller
{
    private $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    public function get(){
        $feature = $this->featureService->main_all();
        return response()->json([
            'message' => "Feature recieved successfully.",
            'feature' => UserFeatureCollection::collection($feature),
        ], 200);
    }

}
