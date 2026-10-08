<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0.0', title: 'BTS API')]
#[OA\Server(url: 'http://localhost:8000')]
#[OA\SecurityScheme(securityScheme: 'sanctum', type: 'http', scheme: 'bearer', description: 'Paste the token returned by register or login')]
#[OA\Tag(name: 'Auth')]
#[OA\Tag(name: 'Products')]
abstract class Controller
{
    //
}
