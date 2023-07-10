<?php

namespace App\Modules\Dashboard\Services;

use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\ResultStores\ResultStore;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;


class DashboardService
{
    private $resultStore;

    public function __construct(ResultStore $resultStore)
    {
        $this->resultStore = $resultStore;
    }

    public function getAppHealthResult(Request $request){

        //code taken from spatie health
        if ($request->has('fresh')) {
            Artisan::call(RunHealthChecksCommand::class);
        }

        $checkResults = $this->resultStore->latestResults();

        return $checkResults;
    }


}
