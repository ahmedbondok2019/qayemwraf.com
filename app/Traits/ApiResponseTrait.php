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
            'status'  => true,
            'success' => true,
            'code'    => (string)$code,
            'message' => $message ? __($message) : __('Operation successful'),
            'error'   => null,
            'errors'  => null,
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
            'status'  => false,
            'success' => false,
            'code'    => (string)$code,
            'message' => $message ? __($message) : __('An error occurred'),
            'error'   => $message ? __($message) : __('An error occurred'),
            'errors'  => $errors,
            'data'    => null,
        ], $code);
    }
}
