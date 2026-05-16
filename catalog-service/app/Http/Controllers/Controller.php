<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "L5 Swagger OpenApi description",
    title: "Catalog Service API"
)]
#[OA\Server(url: '/api/v1')]
#[OA\SecurityScheme(
    securityScheme: "ApiKeyAuth",
    type: "apiKey",
    in: "header",
    name: "X-IAE-KEY"
)]
abstract class Controller
{
    use ApiResponse;
}
