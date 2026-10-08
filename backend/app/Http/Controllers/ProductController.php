<?php

namespace App\Http\Controllers;

use App\DTOs\Product\CreateProductData;
use App\DTOs\Product\PaginationData;
use App\DTOs\Product\UpdateProductData;
use App\Http\Requests\ListProductsRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(ListProductsRequest $request): JsonResponse
    {
        $products = $this->productService->list(PaginationData::fromRequest($request));

        return response()->json($products, 200);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->productService->get($id), 200);
    }

    public function getByCategory(ListProductsRequest $request, int $category): JsonResponse
    {
        $products = $this->productService->byCategory($category, PaginationData::fromRequest($request));

        return response()->json($products, 200);
    }

    public function search(ListProductsRequest $request, string $search): JsonResponse
    {
        $products = $this->productService->search($search, PaginationData::fromRequest($request));

        return response()->json($products, 200);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create(CreateProductData::fromRequest($request));

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->update($id, UpdateProductData::fromRequest($request));

        return response()->json($product, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->productService->delete($id);

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
