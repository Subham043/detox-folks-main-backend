<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Promoter\Exports\PromoterExport;
use App\Modules\Promoter\Services\PromoterService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        ->with('roles', ['App Promoter', 'Reward Riders', 'Referral Rockstars', 'User'])
        ->with('role', $request->query('filter')['has_role'] ?? 'all')
        ->with('search', $request->query('filter')['search'] ?? '')
        ->with('has_date', explode(' - ', ($request->query('filter')['has_date']) ?? ''));
    }

    public function export(Request $request, $user_id){
        $this->service->getPromoterById($user_id);
        $installer = $this->service->exportInstaller($user_id);
        return Excel::download(new PromoterExport($installer), 'installers.xlsx');
    }

    public function destroy($agent_id, $user_id){
        $this->service->getPromoterById($agent_id);
        $this->service->getInstallerById($user_id);
        $this->service->destroy($user_id, $agent_id);
        return redirect()->back()->with('success_status', 'User removed successfully.');
    }

    public function toggle($agent_id, $user_id){
        $this->service->getPromoterById($agent_id);
        $this->service->getInstallerById($user_id);
        try {
            //code...
            $this->service->toggle($user_id, $agent_id);
            return redirect()->back()->with('success_status', 'Status updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('success_status', 'Something went wrong. Please try again');
        }
    }
}
