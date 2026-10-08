<?php

namespace App\DTOs\Product;

use App\Http\Requests\UpdateProductRequest;

final readonly class UpdateProductData
{
    /**
     * @param  array<int, string>|null  $images
     */
    public function __construct(
        public ?string $title = null,
        public ?float $price = null,
        public ?string $description = null,
        public ?int $categoryId = null,
        public ?array $images = null,
    ) {}

    public static function fromRequest(UpdateProductRequest $request): self
    {
        $data = $request->validated();

        return new self(
            title: $data['title'] ?? null,
            price: isset($data['price']) ? (float) $data['price'] : null,
            description: $data['description'] ?? null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            images: isset($data['images']) ? array_values($data['images']) : null,
        );
    }

    /**
     * Only the fields that were sent, so partial updates leave the rest untouched.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'images' => $this->images,
        ], fn ($value) => $value !== null);
    }
}
