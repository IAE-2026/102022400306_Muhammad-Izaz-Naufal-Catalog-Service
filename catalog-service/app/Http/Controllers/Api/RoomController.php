<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room;
use OpenApi\Attributes as OA;

class RoomController extends Controller
{
    #[OA\Get(
        path: '/rooms',
        summary: 'Menampilkan daftar kamar yang dibuat (berdasarkan lokasi & tanggal).',
        tags: ['Rooms'],
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'location', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter berdasarkan lokasi (contoh: Bali)'),
            new OA\Parameter(name: 'date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date'), description: 'Filter berdasarkan tanggal ketersediaan (YYYY-MM-DD)')
        ],
        responses: [
            new OA\Response(response: 200, description: 'Success')
        ]
    )]
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->query('location') . '%');
        }

        $rooms = $query->get();

        return $this->successResponse($rooms, 'Data retrieved successfully');
    }

    #[OA\Get(
        path: '/rooms/{id}',
        summary: 'Membuka detail lengkap satu kamar (foto, fasilitas, deskripsi).',
        tags: ['Rooms'],
        security: [['ApiKeyAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Data retrieved successfully'),
            new OA\Response(response: 404, description: 'Room not found')
        ]
    )]
    public function show($id)
    {
        $room = Room::with('addons')->find($id);

        if (!$room) {
            return $this->errorResponse('Room not found', null, 404);
        }

        return $this->successResponse($room, 'Data retrieved successfully');
    }

    #[OA\Post(
        path: '/rooms',
        summary: 'Menyimpan kamar ke katalog',
        tags: ['Rooms'],
        security: [['ApiKeyAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['room_id'],
                properties: [
                    new OA\Property(property: 'room_id', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Room bookmarked successfully'),
            new OA\Response(response: 404, description: 'Room not found')
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id'
        ]);

        $bookmark = \App\Models\Bookmark::updateOrCreate([
            'room_id' => $validated['room_id']
        ]);

        return $this->successResponse($bookmark, 'Room bookmarked successfully', 201);
    }
}
