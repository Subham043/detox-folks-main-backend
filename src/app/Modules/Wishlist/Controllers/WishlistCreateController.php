<?php

namespace App\Modules\Wishlist\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Wishlist\Requests\WishlistCreateRequest;
use App\Modules\Wishlist\Resources\WishlistCollection;
use App\Modules\Wishlist\Services\WishlistService;

class WishlistCreateController extends Controller
{
    private $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function post(WishlistCreateRequest $request){

        try {
            //code...
            $wishlist = $this->wishlistService->create(
                $request->validated()
            );
            return response()->json([
                'message' => "Wishlist created successfully.",
                'wishlist' => WishlistCollection::make($wishlist),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }

    }
}
