<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

/*
 * Kept apart from Schemas: swagger-php nests schemas declared on the same class into any Parameter there.
 */
#[OA\Parameter(parameter: 'page', name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 1))]
#[OA\Parameter(parameter: 'limit', name: 'limit', in: 'query', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 100, default: 15))]
#[OA\Parameter(parameter: 'productId', name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))]
final class Parameters {}
