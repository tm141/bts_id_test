<?php

namespace App\DTOs\Product;

use App\Http\Requests\ListProductsRequest;

final readonly class PaginationData
{
    public const DEFAULT_PAGE = 1;

    public const DEFAULT_LIMIT = 15;

    public function __construct(
        public int $page = self::DEFAULT_PAGE,
        public int $limit = self::DEFAULT_LIMIT,
    ) {}

    public static function fromRequest(ListProductsRequest $request): self
    {
        $data = $request->validated();

        return new self(
            page: (int) ($data['page'] ?? self::DEFAULT_PAGE),
            limit: (int) ($data['limit'] ?? self::DEFAULT_LIMIT),
        );
    }
}
