<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;

class PromotionController extends Controller
{
public function index()
{
    $promotions = Promotion::where('is_active', true)
        ->where(function ($q) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })
        ->get();

    $promotions->transform(function ($promo) {
        $promo->image = str_starts_with($promo->image, 'http')
            ? $promo->image
            : asset('storage/' . $promo->image);
        return $promo;
    });

    return response()->json(['promotions' => $promotions]);
}
public function store(PromotionRequest $request)
{
    $promotion = Promotion::create($request->validated());

    return response()->json([
        'status' => true,
        'message' => 'Promotion created successfully',
        'promotion' => $promotion,
    ], 201);
}
}