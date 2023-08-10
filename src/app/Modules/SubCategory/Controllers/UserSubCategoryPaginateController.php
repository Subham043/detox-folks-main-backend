<?php

namespace App\Modules\SubCategory\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SubCategory\Resources\UserSubCategoryCollection;
use App\Modules\SubCategory\Services\SubCategoryService;
use Illuminate\Http\Request;

class UserSubCategoryPaginateController extends Controller
{
    private $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    public function get(Request $request){
        $data = $this->subCategoryService->paginateMain($request->total ?? 10);
        return UserSubCategoryCollection::collection($data);
    }

}
