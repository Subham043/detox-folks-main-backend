<?php

namespace App\Modules\Blog\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Resources\UserBlogCollection;
use App\Modules\Blog\Services\BlogService;
use Illuminate\Http\Request;

class UserBlogPaginateController extends Controller
{
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function get(Request $request){
        $data = $this->blogService->paginateMain($request->total ?? 10);
        return UserBlogCollection::collection($data);
    }

}
