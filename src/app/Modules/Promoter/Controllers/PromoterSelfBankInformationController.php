<?php

namespace App\Modules\Promoter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Models\User;
use App\Modules\Promoter\Models\BankInformation;
use App\Modules\Promoter\Requests\BankInformationRequest;

class PromoterSelfBankInformationController extends Controller
{
    public function get(){
        User::with(['roles'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars']); })->findOrFail(auth()->user()->id);
        $bank = BankInformation::where('user_id', auth()->user()->id)->first();
        return view('admin.pages.promoter.installer.bank_information', compact(['bank']));
    }

    public function post(BankInformationRequest $request){
        User::with(['roles'])->whereHas('roles', function($q) { $q->whereIn('name', ['App Promoter', 'Reward Riders', 'Referral Rockstars']); })->findOrFail(auth()->user()->id);
        try {
            //code...
            $bank = BankInformation::updateOrCreate(['user_id' => auth()->user()->id], $request->validated());
            return redirect()->back()->with('success_status', 'Bank information updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
