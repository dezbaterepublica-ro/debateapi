<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiIndex(string $modelClass)
    {
        $httpRequest = request();

        $sortableBy = constant($modelClass . '::SORTABLE_BY');

        /** @var Builder $query */
        $query = call_user_func([$modelClass, 'query']);
        if (!empty($httpRequest->sort) && in_array($httpRequest->sort, $sortableBy)) {
            $query->orderBy($httpRequest->sort);
        }
        $entities = $query->paginate($httpRequest->per_page);

        $entities->appends($httpRequest->query());

        return array_merge(
            $entities->toArray(),
            [
                'sortable_by' => $sortableBy,
            ]
        );
    }
}
