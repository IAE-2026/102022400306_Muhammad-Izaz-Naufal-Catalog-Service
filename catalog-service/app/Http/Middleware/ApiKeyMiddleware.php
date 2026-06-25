<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ApiKeyMiddleware
 *
 * Validates the X-IAE-KEY header on every incoming API request.
 * The key must match the student NIM: 102022400306.
 *
 * Returns HTTP 401 (Unauthorized) with the IAE-T2 error wrapper
 * if the header is missing or does not match.
 */
class ApiKeyMiddleware
{
    /**
     * The expected API key (student NIM).
     */
    private const EXPECTED_KEY = '102022400306';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-IAE-KEY');

        if (!$apiKey || $apiKey !== self::EXPECTED_KEY) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized. Header X-IAE-KEY is missing or invalid.',
                'errors'  => null,
            ], 401);
        }

        return $next($request);
    }
}
