<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Resources\UserCategoryCollection;
use App\Modules\Category\Services\CategoryService;

class UserCategoryDetailController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function get($slug){
        $category = $this->categoryService->getBySlug($slug);
        return response()->json([
            'message' => "Category recieved successfully.",
            'category' => UserCategoryCollection::make($category),
        ], 200);
    }
}
