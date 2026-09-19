<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     */
    public function successResponse($data = null, ?string $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'status' => true,
            'success' => true,
            'code' => (string) $code,
            'message' => $message ? __($message) : __('Operation successful'),
            'error' => null,
            'errors' => null,
        ];

        if (is_array($data) && isset($data['items']) && (isset($data['current_page']) || isset($data['meta']))) {
            $items = $data['items'];
            unset($data['items'], $data['data'], $data['products']);
            $response['data'] = $items;
            $response = array_merge($response, $data);
        } else {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  mixed  $errors
     */
    public function errorResponse(?string $message = null, int $code = 422, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'success' => false,
            'code' => (string) $code,
            'message' => $message ? __($message) : __('An error occurred'),
            'error' => $message ? __($message) : __('An error occurred'),
            'errors' => $errors,
            'data' => null,
        ], $code);
    }
}
