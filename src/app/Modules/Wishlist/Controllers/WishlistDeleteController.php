<?php

namespace App\Modules\Wishlist\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Wishlist\Resources\WishlistCollection;
use App\Modules\Wishlist\Services\WishlistService;

class WishlistDeleteController extends Controller
{
    private $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function delete($id){
        $wishlist = $this->wishlistService->getById($id);

        try {
            //code...
            $this->wishlistService->delete(
                $wishlist
            );
            return response()->json([
                'message' => "Wishlist deleted successfully.",
                'wishlist' => WishlistCollection::make($wishlist),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }

}
