<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addon;
use OpenApi\Attributes as OA;

class AddonController extends Controller
{
    #[OA\Get(
        path: '/api/v1/addons',
        summary: 'Menampilkan menu tambahan seperti sarapan atau asuransi.',
        tags: ['Addons'],
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'X-IAE-KEY',
                in: 'header',
                required: true,
                schema: new OA\Schema(type: 'string', example: '102022400306'),
                description: 'NIM Mahasiswa sebagai API Key'
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Daftar addon berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Addons retrieved successfully'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
                        new OA\Property(
                            property: 'meta',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'service_name', type: 'string', example: 'Catalog-Service'),
                                new OA\Property(property: 'api_version', type: 'string', example: 'v1'),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthorized — X-IAE-KEY missing or invalid')
        ]
    )]
    public function index()
    {
        $addons = Addon::all();

        return $this->successResponse($addons, 'Addons retrieved successfully');
    }
}
