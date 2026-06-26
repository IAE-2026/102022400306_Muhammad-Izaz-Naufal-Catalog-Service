<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\JwksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'SSO', description: 'Federated SSO authentication endpoints')]
class SsoController extends Controller
{
    #[OA\Get(
        path: '/sso/me',
        operationId: 'ssoMe',
        summary: 'Get the authenticated SSO user profile',
        description: 'Returns the current user\'s profile, including their local role, after JWT verification.',
        tags: ['SSO'],
        security: [['bearerAuth' => []], ['ApiKeyAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Authenticated user profile',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'name', type: 'string', example: 'warga11'),
                                new OA\Property(property: 'email', type: 'string', example: 'warga11@ktp.iae.id'),
                                new OA\Property(property: 'sso_sub', type: 'string', example: 'abc-123-def'),
                                new OA\Property(
                                    property: 'role',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'integer', example: 2),
                                        new OA\Property(property: 'name', type: 'string', example: 'viewer'),
                                        new OA\Property(property: 'display_name', type: 'string', example: 'Viewer'),
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthorized — missing or invalid Bearer token or API Key')
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No authenticated user found.',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'      => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'sso_sub' => $user->sso_sub,
                'role'    => $user->role ? [
                    'id'           => $user->role->id,
                    'name'         => $user->role->name,
                    'display_name' => $user->role->display_name,
                ] : null,
            ],
        ]);
    }

    #[OA\Post(
        path: '/sso/verify',
        operationId: 'ssoVerify',
        summary: 'Verify a JWT token and return decoded payload',
        description: 'Accepts a Bearer token, verifies it against the JWKS, and returns the decoded claims. Useful for debugging.',
        tags: ['SSO'],
        security: [['bearerAuth' => []], ['ApiKeyAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Token is valid',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(property: 'message', type: 'string', example: 'Token is valid.'),
                        new OA\Property(property: 'payload', type: 'object')
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Token is invalid or expired or API Key is missing')
        ]
    )]
    public function verify(Request $request, JwksService $jwksService): JsonResponse
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No Bearer token provided.',
            ], 401);
        }

        $payload = $jwksService->verifyToken($token);

        if (!$payload) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token verification failed. Token may be expired or invalid.',
            ], 401);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Token is valid.',
            'payload' => $payload,
        ]);
    }
}
