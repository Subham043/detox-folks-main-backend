<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Models\User;
use App\Modules\Promoter\Models\BankInformation;
use App\Modules\Promoter\Requests\BankInformationRequest;

class PromoterBankInformationController extends Controller
{
    public function get($user_id){
        User::with(['roles'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars']); })->findOrFail($user_id);
        $bank = BankInformation::where('user_id', $user_id)->first();
        return view('admin.pages.promoter.agent.bank_information', compact(['bank', 'user_id']));
    }

    public function post(BankInformationRequest $request, $user_id){
        User::with(['roles'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars']); })->findOrFail($user_id);
        try {
            //code...
            $bank = BankInformation::updateOrCreate(['user_id' => $user_id], $request->validated());
            return redirect()->back()->with('success_status', 'Bank information updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
