<?php

namespace App\Http\Controllers\Api;

class Controller
{
    public function successResponse(mixed $data = null, string $message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success'   => true,
            'data'      => $data,
            'message'   => $message
        ]);
    }

    public function failedResponse(mixed $data = null, string $message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success'   => false,
            'message'   => $message,
            'data'      => $data
        ]);
    }
}
