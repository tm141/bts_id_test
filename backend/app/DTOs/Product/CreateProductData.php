<?php

namespace App\DTOs\Product;

use App\Http\Requests\StoreProductRequest;

final readonly class CreateProductData
{
    /**
     * @param  array<int, string>  $images
     */
    public function __construct(
        public string $title,
        public float $price,
        public ?string $description,
        public int $categoryId,
        public array $images,
    ) {}

    public static function fromRequest(StoreProductRequest $request): self
    {
        $data = $request->validated();

        return new self(
            title: $data['title'],
            price: (float) $data['price'],
            description: $data['description'] ?? null,
            categoryId: (int) $data['category_id'],
            images: array_values($data['images']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'images' => $this->images,
        ];
    }
}
