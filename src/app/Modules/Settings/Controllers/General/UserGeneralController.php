<?php

namespace App\Modules\Settings\Controllers\General;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Resources\UserGeneralCollection;
use App\Modules\Settings\Services\GeneralService;

class UserGeneralController extends Controller
{
    private $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }

    public function get(){
        $general = $this->generalService->getById(1);
        return response()->json([
            'message' => "Partner recieved successfully.",
            'general' => UserGeneralCollection::make($general),
        ], 200);
    }
}
