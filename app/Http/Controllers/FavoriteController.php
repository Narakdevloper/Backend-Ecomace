<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Favorite;
class FavoriteController extends Controller
{
    public function toggle(FavoriteRequest $request, Product $product)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $userId = $user->id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'status' => true,
                'message' => 'Removed from favorites',
                'is_favorite' => false,
            ]);
        }

        Favorite::create([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added to favorites',
            'is_favorite' => true,
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $favorites = Favorite::where('user_id', $user->id)
            ->with('product')
            ->get()
            ->pluck('product');

        return response()->json(['favorites' => $favorites]);
    }
}