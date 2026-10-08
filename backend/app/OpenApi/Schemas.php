<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'username', type: 'string', example: 'andre'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ],
)]
#[OA\Schema(
    schema: 'AuthResult',
    properties: [
        new OA\Property(property: 'user', ref: '#/components/schemas/User'),
        new OA\Property(property: 'token', type: 'string', example: '1|xVwn40VyHdceCnGQqX3awbNFCOhhS8BYJx27LjrD'),
    ],
)]
#[OA\Schema(
    schema: 'Product',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Classic T-Shirt'),
        new OA\Property(property: 'price', type: 'string', example: '19.99'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Soft cotton shirt'),
        new OA\Property(property: 'category_id', type: 'integer', example: 1),
        new OA\Property(property: 'images', type: 'array', items: new OA\Items(type: 'string', format: 'uri'), example: ['https://example.com/shirt.jpg']),
    ],
)]
#[OA\Schema(
    schema: 'ProductInput',
    properties: [
        new OA\Property(property: 'title', type: 'string', maxLength: 255, example: 'Classic T-Shirt'),
        new OA\Property(property: 'price', type: 'number', minimum: 0, example: 19.99),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Soft cotton shirt'),
        new OA\Property(property: 'category_id', type: 'integer', minimum: 1, example: 1),
        new OA\Property(property: 'images', type: 'array', minItems: 1, items: new OA\Items(type: 'string', format: 'uri', maxLength: 2048), example: ['https://example.com/shirt.jpg']),
    ],
)]
#[OA\Schema(
    schema: 'ProductPage',
    properties: [
        new OA\Property(property: 'current_page', type: 'integer', example: 1),
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Product')),
        new OA\Property(property: 'per_page', type: 'integer', example: 15),
        new OA\Property(property: 'total', type: 'integer', example: 42),
        new OA\Property(property: 'last_page', type: 'integer', example: 3),
        new OA\Property(property: 'from', type: 'integer', nullable: true, example: 1),
        new OA\Property(property: 'to', type: 'integer', nullable: true, example: 15),
    ],
)]
#[OA\Schema(
    schema: 'Message',
    properties: [
        new OA\Property(property: 'message', type: 'string'),
    ],
)]
#[OA\Schema(
    schema: 'ValidationError',
    properties: [
        new OA\Property(property: 'message', type: 'string', example: 'The password confirmation does not match.'),
        new OA\Property(property: 'errors', type: 'object', additionalProperties: new OA\AdditionalProperties(type: 'array', items: new OA\Items(type: 'string'))),
    ],
)]
final class Schemas {}
