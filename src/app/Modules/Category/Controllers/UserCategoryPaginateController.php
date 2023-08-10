<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Resources\UserCategoryCollection;
use App\Modules\Category\Services\CategoryService;
use Illuminate\Http\Request;

class UserCategoryPaginateController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function get(Request $request){
        $data = $this->categoryService->paginateMain($request->total ?? 10);
        return UserCategoryCollection::collection($data);
    }

}
