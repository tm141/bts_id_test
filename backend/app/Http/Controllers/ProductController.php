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
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    #[OA\Get(
        path: '/api/products',
        summary: 'List products',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/page'),
            new OA\Parameter(ref: '#/components/parameters/limit'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paginated products', content: new OA\JsonContent(ref: '#/components/schemas/ProductPage')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Invalid pagination', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
        ],
    )]
    public function index(ListProductsRequest $request): JsonResponse
    {
        $products = $this->productService->list(PaginationData::fromRequest($request));

        return response()->json($products, 200);
    }

    #[OA\Get(
        path: '/api/products/{id}',
        summary: 'Get a product',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/productId')],
        responses: [
            new OA\Response(response: 200, description: 'Product', content: new OA\JsonContent(ref: '#/components/schemas/Product')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Not found'),
        ],
    )]
    public function show(int $id): JsonResponse
    {
        return response()->json($this->productService->get($id), 200);
    }

    #[OA\Get(
        path: '/api/products/category/{category}',
        summary: 'List products in a category',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [
            new OA\Parameter(name: 'category', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(ref: '#/components/parameters/page'),
            new OA\Parameter(ref: '#/components/parameters/limit'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paginated products', content: new OA\JsonContent(ref: '#/components/schemas/ProductPage')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Invalid pagination', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
        ],
    )]
    public function getByCategory(ListProductsRequest $request, int $category): JsonResponse
    {
        $products = $this->productService->byCategory($category, PaginationData::fromRequest($request));

        return response()->json($products, 200);
    }

    #[OA\Get(
        path: '/api/products/search/{search}',
        summary: 'Search products',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [
            new OA\Parameter(name: 'search', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: 'shirt'),
            new OA\Parameter(ref: '#/components/parameters/page'),
            new OA\Parameter(ref: '#/components/parameters/limit'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paginated products', content: new OA\JsonContent(ref: '#/components/schemas/ProductPage')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Invalid pagination', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
        ],
    )]
    public function search(ListProductsRequest $request, string $search): JsonResponse
    {
        $products = $this->productService->search($search, PaginationData::fromRequest($request));

        return response()->json($products, 200);
    }

    #[OA\Post(
        path: '/api/products',
        summary: 'Create a product',
        security: [['sanctum' => []]],
        tags: ['Products'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['title', 'price', 'category_id', 'images'],
            allOf: [new OA\Schema(ref: '#/components/schemas/ProductInput')],
        )),
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Product')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
            new OA\Response(response: 429, description: 'Too many write requests'),
        ],
    )]
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create(CreateProductData::fromRequest($request));

        return response()->json($product, 201);
    }

    #[OA\Put(
        path: '/api/products/{id}',
        summary: 'Update a product (send only the fields to change)',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/productId')],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ProductInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Product')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Not found'),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')),
            new OA\Response(response: 429, description: 'Too many write requests'),
        ],
    )]
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->update($id, UpdateProductData::fromRequest($request));

        return response()->json($product, 200);
    }

    #[OA\Delete(
        path: '/api/products/{id}',
        summary: 'Delete a product',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/productId')],
        responses: [
            new OA\Response(response: 200, description: 'Deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Not found'),
            new OA\Response(response: 429, description: 'Too many write requests'),
        ],
    )]
    public function destroy(int $id): JsonResponse
    {
        $this->productService->delete($id);

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
