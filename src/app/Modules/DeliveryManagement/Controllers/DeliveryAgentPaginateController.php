<?php

namespace App\Modules\DeliveryManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\DeliveryManagement\Services\DeliveryManagementService;
use Illuminate\Http\Request;

class DeliveryAgentPaginateController extends Controller
{
    private $service;

    public function __construct(DeliveryManagementService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request){
        $data = $this->service->paginateAgent($request->total ?? 10);
        return view('admin.pages.delivery_management.agent.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}