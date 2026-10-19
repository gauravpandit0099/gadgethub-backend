<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthService
{
    /* common admin/user login */
    public function login(array $data): array
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::where('email', $data['email'])->first();

                if (!$user || !Hash::check($data['password'], $user->password)) {
                    throw new \DomainException('Invalid email or password.');
                }

                if (!in_array($user->role, ['admin', 'user'], true)) {
                    throw new \DomainException('No valid role assigned to this user.');
                }

                $token = $user->createToken('auth_token')->plainTextToken;

                return [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role_type' => $user->role === 'admin' ? 'Admin' : 'User',
                        'roles' => [$user->role],
                        'permissions' => [],
                    ],
                    'token' => $token,
                ];
            });
        } catch (Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /* authenticated user profile */
    public function profile(User $user): array
    {
        try {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_type' => $user->role === 'admin' ? 'Admin' : 'User',
                'roles' => [$user->role],
            ];
        } catch (Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /* logout current token */
    public function logout(User $user): void
    {
        try {
            $user->currentAccessToken()?->delete();
        } catch (Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /* logout all tokens */
    public function logoutAll(User $user): void
    {
        try {
            $user->tokens()->delete();
        } catch (Throwable $e) {
            report($e);
            throw $e;
        }
    }
}