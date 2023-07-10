<?php

namespace App\Modules\TextEditorImage\Services;

use App\Http\Services\FileService;
use App\Modules\TextEditorImage\Models\TextEditorImage;

class TextEditorImageService
{

    public function create(array $data): TextEditorImage
    {
        $texteditor = TextEditorImage::create($data);
        $texteditor->user_id = auth()->user()->id;
        $texteditor->save();
        return $texteditor;
    }

    public function update(array $data, TextEditorImage $texteditor): TextEditorImage
    {
        $texteditor->update($data);
        return $texteditor;
    }

    public function saveImage(TextEditorImage $texteditor): TextEditorImage
    {
        $texteditor_image = (new FileService)->save_file('image', (new TextEditorImage)->image_path);
        return $this->update([
            'image' => $texteditor_image,
        ], $texteditor);
    }

}
