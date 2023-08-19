<?php

namespace App\Modules\Wishlist\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Wishlist\Resources\WishlistCollection;
use App\Modules\Wishlist\Requests\WishlistUpdateRequest;
use App\Modules\Wishlist\Services\WishlistService;

class WishlistUpdateController extends Controller
{
    private $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function post(WishlistUpdateRequest $request, $id){
        $wishlist = $this->wishlistService->getById($id);
        try {
            //code...
            $wishlist = $this->wishlistService->update(
                $request->validated(),
                $wishlist
            );
            return response()->json([
                'message' => "Wishlist updated successfully.",
                'wishlist' => WishlistCollection::make($wishlist),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
