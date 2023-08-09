<?php

namespace App\Modules\Partner\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Partner\Resources\UserPartnerCollection;
use App\Modules\Partner\Services\PartnerService;

class UserPartnerAllController extends Controller
{
    private $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function get(){
        $partner = $this->partnerService->main_all();
        return response()->json([
            'message' => "Partner recieved successfully.",
            'partner' => UserPartnerCollection::collection($partner),
        ], 200);
    }

}
