<?php

namespace App\Modules\Blog\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Services\BlogService;
use Illuminate\Http\Request;

class BlogPaginateController extends Controller
{
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->middleware('permission:list blogs', ['only' => ['get']]);
        $this->blogService = $blogService;
    }

    public function get(Request $request){
        $data = $this->blogService->paginate($request->total ?? 10);
        return view('admin.pages.blog.paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}
