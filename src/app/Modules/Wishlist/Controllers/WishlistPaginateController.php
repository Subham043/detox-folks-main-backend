<?php

namespace App\Modules\Wishlist\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Wishlist\Resources\WishlistCollection;
use App\Modules\Wishlist\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistPaginateController extends Controller
{
    private $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function get(Request $request){
        $data = $this->wishlistService->paginate($request->total ?? 10);
        return WishlistCollection::collection($data);
    }

}
