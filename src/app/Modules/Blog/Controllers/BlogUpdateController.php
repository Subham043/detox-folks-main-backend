<?php

namespace App\Modules\Blog\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Requests\BlogUpdateRequest;
use App\Modules\Blog\Services\BlogService;

class BlogUpdateController extends Controller
{
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->middleware('permission:edit blogs', ['only' => ['get','post']]);
        $this->blogService = $blogService;
    }

    public function get($id){
        $data = $this->blogService->getById($id);
        return view('admin.pages.blog.update', compact(['data']));
    }

    public function post(BlogUpdateRequest $request, $id){
        $blog = $this->blogService->getById($id);
        try {
            //code...
            $this->blogService->update(
                $request->except(['image']),
                $blog
            );
            if($request->hasFile('image')){
                $this->blogService->saveImage($blog);
            }
            return response()->json(["message" => "Blog updated successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
