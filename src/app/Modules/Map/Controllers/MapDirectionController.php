<?php

namespace App\Modules\Map\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\OlaMapService;
use App\Modules\Map\Requests\DirectionRequest;

class MapDirectionController extends Controller
{
    public function get(DirectionRequest $request){
        $request->validated();
        $data = (new OlaMapService)->get_direction($request->origin_lat, $request->origin_lng, $request->destination_lat, $request->destination_lng);
        return response()->json(['data' => $data], 200);
    }

}