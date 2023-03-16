<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedCollection extends ResourceCollection
{
    private string $resourceClass;

    public function __construct($resource, $resourceClass)
    {
        parent::__construct($resource);
        $this->resource = $this->collectResource($resource);
        $this->resourceClass = $resourceClass;
    }

    public function toArray($request) : array
    {
        return [
            'data' => $this->resourceClass::collection(
                $this->collection
            ),
            'pagination' => $this->pagination(),
        ];
    }

    public function pagination() : array
    {
        return [
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'path' => $this->path(),
            'next_page_url' => $this->nextPageUrl(),
            'prev_page_url' => $this->previousPageUrl(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
        ];
    }
}
