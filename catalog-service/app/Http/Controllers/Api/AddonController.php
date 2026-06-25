<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addon;
use OpenApi\Attributes as OA;

class AddonController extends Controller
{
    #[OA\Get(
        path: '/addons',
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
            new OA\Response(response: 200, description: 'Daftar addon berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthorized — X-IAE-KEY missing or invalid')
        ]
    )]
    public function index()
    {
        $addons = Addon::all();

        return $this->successResponse($addons, 'Addons retrieved successfully');
    }
}
