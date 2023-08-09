<?php

namespace App\Modules\Legal\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Legal\Resources\UserLegalCollection;
use App\Modules\Legal\Services\LegalService;

class UserLegalDetailController extends Controller
{
    private $legalService;

    public function __construct(LegalService $legalService)
    {
        $this->legalService = $legalService;
    }

    public function get($slug){
        $legal = $this->legalService->getBySlug($slug);
        return response()->json([
            'message' => "Legal Pages recieved successfully.",
            'legal' => UserLegalCollection::make($legal),
        ], 200);
    }

}
