<?php

namespace App\Modules\SubCategory\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SubCategory\Resources\UserSubCategoryCollection;
use App\Modules\SubCategory\Services\SubCategoryService;

class UserSubCategoryDetailController extends Controller
{
    private $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    public function get($slug){
        $subCategory = $this->subCategoryService->getBySlug($slug);
        return response()->json([
            'message' => "SubCategory recieved successfully.",
            'subCategory' => UserSubCategoryCollection::make($subCategory),
        ], 200);
    }
}
