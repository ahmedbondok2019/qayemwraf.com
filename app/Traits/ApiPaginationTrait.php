<?php

namespace App\Traits;

trait ApiPaginationTrait
{
    public function paginateResponse($paginator, $resource = null, array $extra = [])
    {
        return array_merge([
            'data' => $resource ?? $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ], $extra);
    }
}
