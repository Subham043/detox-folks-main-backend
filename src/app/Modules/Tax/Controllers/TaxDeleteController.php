<?php

namespace App\Modules\Tax\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tax\Services\TaxService;

class TaxDeleteController extends Controller
{
    private $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function get($id){
        $tax = $this->taxService->getById($id);

        try {
            //code...
            $this->taxService->delete(
                $tax
            );
            return redirect()->back()->with('success_status', 'Tax deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
