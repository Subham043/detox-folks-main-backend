<?php

namespace App\Modules\SubCategory\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SubCategory\Services\SubCategoryService;

class SubCategoryDeleteController extends Controller
{
    private $subcategoryService;

    public function __construct(SubCategoryService $subcategoryService)
    {
        $this->subcategoryService = $subcategoryService;
    }

    public function get($id){
        $subcategory = $this->subcategoryService->getById($id);

        try {
            //code...
            $this->subcategoryService->delete(
                $subcategory
            );
            return redirect()->back()->with('success_status', 'SubCategory deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}