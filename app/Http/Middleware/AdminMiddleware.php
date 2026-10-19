<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = $request->user('web');

            if (!$user) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Unauthenticated.',
                    'data' => null,
                ], 401);
            }

            if ($user->role !== 'admin') {
                return response()->json([
                    'code' => 403,
                    'message' => 'Access denied. Admin only.',
                    'data' => null,
                ], 403);
            }

            return $next($request);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'code' => 500,
                'message' => 'Authorization failed.',
                'data' => null,
            ], 500);
        }
    }
}
