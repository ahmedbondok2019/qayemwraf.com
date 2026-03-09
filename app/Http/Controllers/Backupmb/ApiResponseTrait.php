<?php

namespace App\Http\Controllers\Api;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait ApiResponseTrait
{
    public $paginate = 4;

    /*
     * [
     *  'data' => '',
     *  'status' => true, false,
     *  'error' => ''
     * ]*/

    public function ApiResponse($data = null, $error = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'status' => in_array($code, $this->successCode()) ? true : false,
            'error' => $error,
        ];

        return response($array, $code);
    }

    public function NewApiResponse($data = null, $error = null, $status = true, $code = 200)
    {
        $array = [
            'data' => $data,
            'error' => $error,
            'status' => $status == 'true' ? true : false,
            'code' => $code,
        ];

        return response($array, $code);
    }

    public function successCode()
    {
        return [
            '200', '201', '202',
        ];
    }

    public function NotFoundResponse()
    {
        return $this->ApiResponse('', 'Category Not Found', 404);
    }

    public function paginate($items, $perPage = 4, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
