<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Promoter\Requests\PromoterRequest;
use App\Modules\Promoter\Services\PromoterService;
use Illuminate\Http\Request;

class PromoterInstallerPaginateController extends Controller
{
    private $service;

    public function __construct(PromoterService $service)
    {
        $this->service = $service;
    }

    public function get(Request $request){
        $installer = $this->service->paginateInstaller(auth()->user()->id, $request->total ?? 10);
        return view('admin.pages.promoter.installer.index', compact(['installer']))
        ->with('search', $request->query('filter')['search'] ?? '')
        ->with('has_date', explode(' - ', ($request->query('filter')['has_date']) ?? ''));
    }

    public function promote(PromoterRequest $request){
        $request->validated();
        $this->service->promote($request->email, auth()->user()->id);
        return redirect()->back()->with('success_status', 'User promoted successfully.');
    }

    public function destroy($user_id){
        $this->service->destroy($user_id, auth()->user()->id);
        return redirect()->back()->with('success_status', 'User removed successfully.');
    }
}
