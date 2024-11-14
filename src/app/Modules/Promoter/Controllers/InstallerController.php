<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Promoter\Models\Promoter;
use App\Modules\Promoter\Models\PromoterCode;
use App\Modules\Promoter\Requests\InstallerRequest;

class InstallerController extends Controller
{
    public function get(){
        $promoter = Promoter::with('promoted_by')->where('installed_by_id', auth()->user()->id)->first();
        if($promoter){
            return response()->json([
                'message' => "Promoted fetched successfully.",
                'promoted' => true,
                'promoter' => array(
                    'id' => $promoter->promoted_by->id,
                    'name' => $promoter->promoted_by->name,
                    'email' => $promoter->promoted_by->email,
                )
            ], 200);
        }
        return response()->json([
            'message' => "User has not applied any promotion code.",
            'promoted' => false,
        ], 200);
    }

    public function post(InstallerRequest $request){
        $request->validated();
        $app_promoter_codes = PromoterCode::with(['promoter'])->where('code', $request->code)->firstOrFail();
        $promoter = Promoter::where('installed_by_id', auth()->user()->id)->first();
        if($promoter){
            return response()->json([
                'message' => "The code has already been used by you.",
            ], 400);
        }else{
            Promoter::create([
                'installed_by_id' => auth()->user()->id,
                'promoted_by_id' => $app_promoter_codes->promoter->id
            ]);
        }
        return response()->json([
            'message' => "User promoted successfully.",
            'promoted' => true,
        ], 200);
    }
}
