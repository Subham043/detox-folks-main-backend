<?php

namespace App\Modules\Blog\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Requests\BlogCreateRequest;
use App\Modules\Blog\Services\BlogService;

class BlogCreateController extends Controller
{
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->middleware('permission:create blogs', ['only' => ['get','post']]);
        $this->blogService = $blogService;
    }

    public function get(){
        return view('admin.pages.blog.create');
    }

    public function post(BlogCreateRequest $request){

        try {
            //code...
            $blog = $this->blogService->create(
                $request->except(['image'])
            );
            if($request->hasFile('image')){
                $this->blogService->saveImage($blog);
            }
            return response()->json(["message" => "Blog created successfully."], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
