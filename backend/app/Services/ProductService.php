<?php

namespace App\Services;

use App\DTOs\Product\CreateProductData;
use App\DTOs\Product\PaginationData;
use App\DTOs\Product\UpdateProductData;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    private const CACHE_TTL = 600;

    private const VERSION_KEY = 'products:version';

    public function __construct(private ProductRepository $productRepository) {}

    public function list(PaginationData $pagination): LengthAwarePaginator
    {
        return Cache::remember(
            $this->listKey('all', $pagination),
            self::CACHE_TTL,
            fn () => $this->productRepository->paginate($pagination->page, $pagination->limit),
        );
    }

    public function byCategory(int $categoryId, PaginationData $pagination): LengthAwarePaginator
    {
        return Cache::remember(
            $this->listKey("category:{$categoryId}", $pagination),
            self::CACHE_TTL,
            fn () => $this->productRepository->paginateByCategory($categoryId, $pagination->page, $pagination->limit),
        );
    }

    public function search(string $term, PaginationData $pagination): LengthAwarePaginator
    {
        $hash = md5(mb_strtolower($term));

        return Cache::remember(
            $this->listKey("search:{$hash}", $pagination),
            self::CACHE_TTL,
            fn () => $this->productRepository->paginateSearch($term, $pagination->page, $pagination->limit),
        );
    }

    public function get(int $id): Product
    {
        return Cache::remember(
            $this->itemKey($id),
            self::CACHE_TTL,
            fn () => $this->productRepository->findOrFail($id),
        );
    }

    public function create(CreateProductData $data): Product
    {
        $product = $this->productRepository->create($data->toArray());

        $this->bumpVersion();

        return $product;
    }

    public function update(int $id, UpdateProductData $data): Product
    {
        $product = $this->productRepository->update(
            $this->productRepository->findOrFail($id),
            $data->toArray(),
        );

        $this->bumpVersion();
        Cache::forget($this->itemKey($id));

        return $product;
    }

    public function delete(int $id): void
    {
        $this->productRepository->delete($this->productRepository->findOrFail($id));

        $this->bumpVersion();
        Cache::forget($this->itemKey($id));
    }

    private function listKey(string $scope, PaginationData $pagination): string
    {
        return "products:v{$this->version()}:{$scope}:p{$pagination->page}:l{$pagination->limit}";
    }

    private function itemKey(int $id): string
    {
        return "products:item:{$id}";
    }

    private function version(): int
    {
        return (int) Cache::get(self::VERSION_KEY, 1);
    }

    private function bumpVersion(): void
    {
        Cache::forever(self::VERSION_KEY, $this->version() + 1);
    }
}
