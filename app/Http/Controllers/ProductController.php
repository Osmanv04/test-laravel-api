<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductPriceRequest;
use App\Http\Resources\ProductPriceResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::with('currency')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return ProductResource::make($product->load('currency'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('currency')->findOrFail($id);
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return ProductResource::make($product->load('currency'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->noContent();
    }

    public function prices(string $id)
    {
        $product = Product::with('currency')->findOrFail($id);
        return ProductPriceResource::collection($product->prices()->with('currency')->get());
    }

    public function storePrice(StoreProductPriceRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $productPrice = $product->prices()->create($request->validated());
        return new ProductPriceResource($productPrice->load('currency'));
    }
}
