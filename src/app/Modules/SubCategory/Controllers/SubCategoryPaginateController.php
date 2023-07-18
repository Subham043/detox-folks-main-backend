<?php

namespace App\Modules\SubCategory\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SubCategory\Services\SubCategoryService;
use Illuminate\Http\Request;

class SubCategoryPaginateController extends Controller
{
    private $subcategoryService;

    public function __construct(SubCategoryService $subcategoryService)
    {
        $this->middleware('permission:list categories', ['only' => ['get']]);
        $this->subcategoryService = $subcategoryService;
    }

    public function get(Request $request){
        $data = $this->subcategoryService->paginate($request->total ?? 10);
        return view('admin.pages.sub_category.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
