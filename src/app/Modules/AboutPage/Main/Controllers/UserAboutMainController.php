<?php

namespace App\Modules\AboutPage\Main\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AboutPage\Main\Resources\UserAboutMainCollection;
use App\Modules\AboutPage\Main\Services\MainService;

class UserAboutMainController extends Controller
{
    private $mainService;

    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function get(){
        $about = $this->mainService->getBySlug('about_section');
        return response()->json([
            'message' => "About section recieved successfully.",
            'about' => UserAboutMainCollection::make($about),
        ], 200);
    }
}
