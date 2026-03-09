<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     * @param  string|null  $message
     * @param  int  $code
     * @return JsonResponse
     */
    public function successResponse($data = null, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message ? __($message) : __('Operation successful'),
            'data'    => $data,
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string|null  $message
     * @param  int  $code
     * @param  mixed  $errors
     * @return JsonResponse
     */
    public function errorResponse(string $message = null, int $code = 422, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ? __($message) : __('An error occurred'),
            'errors'  => $errors,
        ], $code);
    }
}
