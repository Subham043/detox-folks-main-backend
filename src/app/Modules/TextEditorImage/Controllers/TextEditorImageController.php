<?php

namespace App\Modules\TextEditorImage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\TextEditorImage\Requests\TextEditorImageRequest;
use App\Modules\TextEditorImage\Services\TextEditorImageService;

class TextEditorImageController extends Controller
{
    private $textEditorImageService;

    public function __construct(TextEditorImageService $textEditorImageService)
    {
        $this->textEditorImageService = $textEditorImageService;
    }

    public function post(TextEditorImageRequest $request){

        try {
            //code...
            $image = $this->textEditorImageService->create(
                $request->validated()
            );
            if($request->hasFile('image')){
                $this->textEditorImageService->saveImage($image);
            }
            return response()->json(["message" => "TextEditorImage created successfully.", 'image' => $image->image_link], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
