<?php

namespace App\Modules\Wishlist\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Wishlist\Resources\WishlistCollection;
use App\Modules\Wishlist\Services\WishlistService;

class WishlistDetailController extends Controller
{
    private $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function get($id){
        $wishlist = $this->wishlistService->getById($id);
        return response()->json([
            'message' => "Wishlist recieved successfully.",
            'wishlist' => WishlistCollection::make($wishlist),
        ], 200);
    }
}
