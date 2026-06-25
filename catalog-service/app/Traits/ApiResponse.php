<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Build a success response matching the IAE-T2 wrapper contract.
     *
     * {
     *   "status": "success",
     *   "message": "...",
     *   "data": { ... },
     *   "meta": { "service_name": "Catalog-Service", "api_version": "v1" }
     * }
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = 'Data retrieved successfully', $code = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
            'meta'    => [
                'service_name' => 'Catalog-Service',
                'api_version'  => 'v1',
            ],
        ], $code);
    }

    /**
     * Build an error response matching the IAE-T2 wrapper contract.
     *
     * {
     *   "status": "error",
     *   "message": "...",
     *   "errors": null
     * }
     *
     * @param  string  $message
     * @param  mixed  $errors
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = 'Resource not found', $errors = null, $code = 404)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
