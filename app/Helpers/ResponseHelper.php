<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success(
        mixed $data = null,
        string $message = 'Success.',
        int $code = 200
    ) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error(
        string $message = 'Something went wrong.',
        int $code = 500,
        mixed $data = null
    ) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}