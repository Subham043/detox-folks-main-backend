<?php

namespace App\Modules\Map\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\OlaMapService;
use App\Modules\Map\Requests\ReverseGeocodingRequest;

class MapReverseGeocodingController extends Controller
{
    public function get(ReverseGeocodingRequest $request){
        $request->validated();
        $data = (new OlaMapService)->get_reverse_geoconding($request->lat, $request->lng);
        return response()->json(['data' => $data], 200);
    }

}