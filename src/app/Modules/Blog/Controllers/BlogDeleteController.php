<?php

namespace App\Modules\Blog\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Services\BlogService;

class BlogDeleteController extends Controller
{
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->middleware('permission:delete blogs', ['only' => ['get']]);
        $this->blogService = $blogService;
    }

    public function get($id){
        $blog = $this->blogService->getById($id);

        try {
            //code...
            $this->blogService->delete(
                $blog
            );
            return redirect()->back()->with('success_status', 'Blog deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}
