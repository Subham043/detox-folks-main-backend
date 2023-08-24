<?php

namespace App\Modules\Charge\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Charge\Services\ChargeService;

class ChargeDeleteController extends Controller
{
    private $chargeService;

    public function __construct(ChargeService $chargeService)
    {
        $this->middleware('permission:delete charges', ['only' => ['get']]);
        $this->chargeService = $chargeService;
    }

    public function get($id){
        $charge = $this->chargeService->getById($id);

        try {
            //code...
            $this->chargeService->delete(
                $charge
            );
            return redirect()->back()->with('success_status', 'Charge deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
