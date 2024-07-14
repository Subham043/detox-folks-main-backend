<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryPaginateController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function get(Request $request){
        $data = $this->categoryService->paginate($request->total ?? 10);
        return view('admin.pages.category.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}