<?php

namespace App\Modules\WarehouseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\WarehouseManagement\Services\WarehouseManagementService;
use Illuminate\Http\Request;

class WarehouseOrderPaginateController extends Controller
{
    private $service;

    public function __construct(WarehouseManagementService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request){
        $order = $this->service->paginateOrder($request->total ?? 10);
        return view('admin.pages.warehouse_management.index', compact(['order']))
        ->with('search', $request->query('filter')['search'] ?? '');
    }
}
