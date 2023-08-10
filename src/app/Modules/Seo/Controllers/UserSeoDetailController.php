<?php

namespace App\Modules\Seo\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seo\Resources\UserSeoCollection;
use App\Modules\Seo\Services\SeoService;

class UserSeoDetailController extends Controller
{
    private $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function get($slug){
        $seo = $this->seoService->getBySlug($slug);
        return response()->json([
            'message' => "Seo recieved successfully.",
            'seo' => UserSeoCollection::make($seo),
        ], 200);
    }
}
