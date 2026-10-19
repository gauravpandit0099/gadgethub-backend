<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        try {
            $user = $request->user();

            if (!$user) {
                return ResponseHelper::error('Unauthenticated.', 401);
            }

            if (!in_array($user->role, $roles, true)) {
                return ResponseHelper::error(
                    'You are not authorized to access this resource.',
                    403
                );
            }

            return $next($request);
        } catch (Throwable $e) {
            report($e);

            return ResponseHelper::error(
                'Authorization failed.',
                500
            );
        }
    }
}