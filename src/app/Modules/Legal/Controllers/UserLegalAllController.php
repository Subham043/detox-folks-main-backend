<?php

namespace App\Modules\Legal\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Legal\Resources\UserLegalCollection;
use App\Modules\Legal\Services\LegalService;

class UserLegalAllController extends Controller
{
    private $legalService;

    public function __construct(LegalService $legalService)
    {
        $this->legalService = $legalService;
    }

    public function get(){
        $legal = $this->legalService->main_all();
        return response()->json([
            'message' => "Legal Pages recieved successfully.",
            'legal' => UserLegalCollection::collection($legal),
        ], 200);
    }

}
