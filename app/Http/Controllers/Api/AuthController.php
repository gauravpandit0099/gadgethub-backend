<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DomainException;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /* login */
    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->login($request->validated());

            return ResponseHelper::success(
                $data,
                'Login successful.'
            );
        } catch (DomainException $e) {
            return ResponseHelper::error($e->getMessage(), 401);
        } catch (Throwable $e) {
            report($e);

            return ResponseHelper::error(
                'Login failed. Please try again.',
                500
            );
        }
    }

    /* authenticated profile */
    public function profile(Request $request): JsonResponse
    {
        try {
            return ResponseHelper::success(
                $this->authService->profile($request->user()),
                'Profile fetched successfully.'
            );
        } catch (Throwable $e) {
            report($e);

            return ResponseHelper::error(
                'Unable to fetch profile.',
                500
            );
        }
    }

    /* logout current token */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());

            return ResponseHelper::success(
                null,
                'Logout successful.'
            );
        } catch (Throwable $e) {
            report($e);

            return ResponseHelper::error(
                'Unable to logout.',
                500
            );
        }
    }

    /* logout all devices */
    public function logoutAll(Request $request): JsonResponse
    {
        try {
            $this->authService->logoutAll($request->user());

            return ResponseHelper::success(
                null,
                'Logged out from all devices successfully.'
            );
        } catch (Throwable $e) {
            report($e);

            return ResponseHelper::error(
                'Unable to logout from all devices.',
                500
            );
        }
    }
}