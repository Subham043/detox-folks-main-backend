<?php

namespace App\Modules\Feature\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Feature\Services\FeatureService;

class FeatureDeleteController extends Controller
{
    private $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->middleware('permission:delete features', ['only' => ['get']]);
        $this->featureService = $featureService;
    }

    public function get($id){
        $feature = $this->featureService->getById($id);

        try {
            //code...
            $this->featureService->delete(
                $feature
            );
            return redirect()->back()->with('success_status', 'Feature deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
