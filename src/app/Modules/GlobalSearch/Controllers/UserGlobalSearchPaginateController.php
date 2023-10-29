<?php

namespace App\Modules\GlobalSearch\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GlobalSearch\Resources\UserGlobalSearchCollection;
use App\Modules\GlobalSearch\Services\GlobalSearchService;
use Illuminate\Http\Request;

class UserGlobalSearchPaginateController extends Controller
{
    private $gloablSearchService;

    public function __construct(GlobalSearchService $gloablSearchService)
    {
        $this->gloablSearchService = $gloablSearchService;
    }

    public function get(Request $request){
        $data = $this->gloablSearchService->paginateMain($request->total ?? 10);
        return UserGlobalSearchCollection::collection($data);
    }

}
