<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Promoter\Services\PromoterService;
use Illuminate\Http\Request;

class PromoterInstalledController extends Controller
{
    private $service;

    public function __construct(PromoterService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request, $user_id){
        $agent = $this->service->getPromoterById($user_id);
        $installer = $this->service->paginateInstaller($user_id, $request->total ?? 10);
        return view('admin.pages.promoter.agent.installer', compact(['agent', 'installer', 'user_id']))
        ->with('search', $request->query('filter')['search'] ?? '')
        ->with('has_date', explode(' - ', ($request->query('filter')['has_date']) ?? ''));
    }

    public function destroy($agent_id, $user_id){
        $this->service->getPromoterById($agent_id);
        $this->service->getInstallerById($user_id);
        $this->service->destroy($user_id, $agent_id);
        return redirect()->back()->with('success_status', 'User removed successfully.');
    }
}
