<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Models\User;
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
        $code = User::with(['roles', 'app_promoter'])->whereHas('roles', function($q) { $q->where('name', 'App Promoter'); })->findOrFail(auth()->user()->id)->app_promoter_code->code;
        $installer = $this->service->paginateInstaller(auth()->user()->id, $request->total ?? 10);
        return view('admin.pages.promoter.installer.index', compact(['installer']))
        ->with('code', $code)
        ->with('search', $request->query('filter')['search'] ?? '')
        ->with('has_date', explode(' - ', ($request->query('filter')['has_date']) ?? ''));
    }

}
