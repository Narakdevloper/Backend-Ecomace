<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Porducts\StoreProductsRequest;
use App\Http\Resources\ProductResource;
use App\Models\Categories;
use App\Http\Resources\CategoryResource;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $categories=Categories::with('products')->get();
    $featureedProducts=$categories->flatMap(function ($category) {
        return $category->products;
    })->take(10);
    return response()->json([
        'categories'=>CategoryResource::collection($categories),
        'featured_products' => ProductResource::collection($featureedProducts),
        
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreProductsRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
          $data['image'] = $imagePath;
        }
        $product=Product::create($data);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(StoreProductsRequest $request, Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreProductsRequest $request, Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductsRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreProductsRequest $request, Product $product)
    {
        //
    }
}
