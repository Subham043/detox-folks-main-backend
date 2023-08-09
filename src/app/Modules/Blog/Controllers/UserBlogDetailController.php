<?php

namespace App\Modules\Blog\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Resources\UserBlogCollection;
use App\Modules\Blog\Services\BlogService;

class UserBlogDetailController extends Controller
{
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function get($slug){
        $blog = $this->blogService->getBySlug($slug);
        return response()->json([
            'message' => "Blog recieved successfully.",
            'blog' => UserBlogCollection::make($blog),
        ], 200);
    }
}
