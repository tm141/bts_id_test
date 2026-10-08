<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    public function paginate(int $page, int $limit): LengthAwarePaginator
    {
        return $this->paginateQuery(Product::query(), $page, $limit);
    }

    public function paginateByCategory(int $categoryId, int $page, int $limit): LengthAwarePaginator
    {
        return $this->paginateQuery(
            Product::where('category_id', $categoryId),
            $page,
            $limit,
        );
    }

    public function paginateSearch(string $term, int $page, int $limit): LengthAwarePaginator
    {
        return $this->paginateQuery(
            Product::where('title', 'ilike', '%'.$term.'%'),
            $page,
            $limit,
        );
    }

    public function findOrFail(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->refresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    /**
     * @param  Builder<Product>  $query
     */
    private function paginateQuery(Builder $query, int $page, int $limit): LengthAwarePaginator
    {
        return $query
            ->orderByDesc('id')
            ->paginate(perPage: $limit, page: $page)
            ->withQueryString();
    }
}
