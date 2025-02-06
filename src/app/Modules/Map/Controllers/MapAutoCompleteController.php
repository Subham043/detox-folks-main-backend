<?php

namespace App\Modules\Map\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\OlaMapService;
use App\Modules\Map\Requests\AutoCompleteRequest;

class MapAutoCompleteController extends Controller
{
    public function get(AutoCompleteRequest $request){
        $request->validated();
        $key = $request->key;
        $data = (new OlaMapService)->get_autocomplete($key);
        $result = array_map(function($item){
            return array(
                'description' => $item->description,
                'geometry' => $item->geometry,
                'place_id' => $item->place_id,
            );
        }, $data);
        return response()->json(['data' => $result], 200);
    }

}
