<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Category\Services\CategoryService;

class CategoryDeleteController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('permission:delete categories', ['only' => ['get']]);
        $this->categoryService = $categoryService;
    }

    public function get($id){
        $category = $this->categoryService->getById($id);

        try {
            //code...
            $this->categoryService->delete(
                $category
            );
            return redirect()->back()->with('success_status', 'Category deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
