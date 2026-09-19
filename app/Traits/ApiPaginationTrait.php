<?php

namespace App\Traits;

trait ApiPaginationTrait
{
    public function paginateResponse($paginator, $resource = null, array $extra = [])
    {
        $items = $resource ? $resource->resolve() : $paginator->items();

        return array_merge([
            'data' => $items,
            'items' => $items,
            'products' => $items,
            'current_page' => (int) $paginator->currentPage(),
            'last_page' => (int) $paginator->lastPage(),
            'per_page' => (int) $paginator->perPage(),
            'total' => (int) $paginator->total(),
            'from' => (int) $paginator->firstItem(),
            'to' => (int) $paginator->lastItem(),
            'has_more' => (bool) $paginator->hasMorePages(),
            'meta' => [
                'current_page' => (int) $paginator->currentPage(),
                'last_page' => (int) $paginator->lastPage(),
                'per_page' => (int) $paginator->perPage(),
                'total' => (int) $paginator->total(),
                'from' => (int) $paginator->firstItem(),
                'to' => (int) $paginator->lastItem(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ], $extra);
    }
}
