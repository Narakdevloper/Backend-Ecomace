<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return response()->json([
            'reviews' => $reviews->items(),
            'average_rating' => round($product->reviews()->avg('rating') ?? 0, 2),
            'reviews_count' => $product->reviews()->count(),
            'current_page' => $reviews->currentPage(),
            'last_page' => $reviews->lastPage(),
        ]);
    }

    public function store(StoreReviewRequest $request, Product $product)
    {
        $review = $product->reviews()->updateOrCreate(
            ['user_id' => Auth::id()],
            $request->validated()
        );

        return response()->json([
            'message' => 'Review saved successfully',
            'review' => $review->load('user:id,name'),
            'average_rating' => round($product->reviews()->avg('rating') ?? 0, 2),
        ], 201);
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return response()->json([
            'message' => 'Review updated successfully',
            'review' => $review->fresh('user:id,name'),
            'average_rating' => round($review->product->reviews()->avg('rating') ?? 0, 2),
        ]);
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = $review->product;
        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully',
            'average_rating' => round($product->reviews()->avg('rating') ?? 0, 2),
        ]);
    }
}