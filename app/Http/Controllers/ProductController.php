<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductPriceRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductPriceResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('currency', 'prices.currency')->get();

        return $this->successResponse(ProductResource::collection($products), 'Productos cargados correctamente');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return $this->successResponse(new ProductResource($product->load('currency')), 'Producto creado correctamente', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('currency', 'prices.currency')->findOrFail($id);

        return $this->successResponse(ProductResource::make($product), 'Producto cargado correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());

        return $this->successResponse(ProductResource::make($product->load('currency')), 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->successResponse(null, 'Producto eliminado correctamente', 204);
    }

    public function prices(string $id)
    {
        $product = Product::with('currency')->findOrFail($id);

        return $this->successResponse(ProductPriceResource::collection($product->prices()->with('currency')->get()), 'Precios del producto cargados correctamente');
    }

    public function storePrice(StoreProductPriceRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $productPrice = $product->prices()->create($request->validated());

        return $this->successResponse(new ProductPriceResource($productPrice->load('currency')), 'Precio del producto creado correctamente', 201);
    }
}
