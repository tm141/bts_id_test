<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'price', 'description', 'category_id', 'images'])]
#[Hidden(['created_at', 'updated_at'])]
class Product extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'category_id' => 'integer',
            'images' => 'array',
        ];
    }
}
