<?php

namespace App\Modules\Partner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Partner\Services\PartnerService;

class PartnerDeleteController extends Controller
{
    private $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->middleware('permission:delete partners', ['only' => ['get']]);
        $this->partnerService = $partnerService;
    }

    public function get($id){
        $partner = $this->partnerService->getById($id);

        try {
            //code...
            $this->partnerService->delete(
                $partner
            );
            return redirect()->back()->with('success_status', 'Partner deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
