<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiIndex(string $selectedModelClass)
    {
        $httpRequest = request();

        $sortableBy = constant($selectedModelClass . '::SORTABLE_BY');
        $selectable = constant($selectedModelClass . '::CAN_SELECT');

        /** @var Builder $query */
        $query = call_user_func([$selectedModelClass, 'query']);

        $resourceName = Str::singular($query->getModel()->getTable());

        // Sorting
        if (!empty($httpRequest->sort)) {
            $sortParameters = explode(',', $httpRequest->sort);
            foreach ($sortParameters as $sortParameter) {
                $orderTypeFlag = substr($sortParameter, 0, 1);
                switch ($orderTypeFlag) {
                    case '+':
                        $sortType = 'ASC';
                        $sortingBy = substr($sortParameter, 1);
                    break;
                    case '-':
                        $sortType = 'DESC';
                        $sortingBy = substr($sortParameter, 1);
                    break;
                    default:
                        $sortType = 'ASC';
                        $sortingBy = $sortParameter;
                }
                $query->orderBy($sortingBy, $sortType);
            }
        }

        // Required fields
        if (!empty($httpRequest->fields) && is_array($httpRequest->fields)) {
            $selectedFields = $httpRequest->fields;

            // Remove non-comma delimited arrays from the fields
            $selectedFields = array_filter(
                $selectedFields,
                function ($item) {
                    if (empty($item)) {
                        return false;
                    }

                    return true;
                }
            );

            // Convert comma-delimited array to PHP array
            $selectedFields = array_map(
                function ($item) {
                    return explode(',', $item);
                },
                $selectedFields
            );

            // Filter by selectable fields
            foreach ($selectedFields as $selectedModel => $fields) {
                $selectedModelClass = 'App\\' . ucwords(strtolower($selectedModel));
                if (class_exists($selectedModelClass)) {
                    $selectedFields[$selectedModel] = array_filter(
                        $fields,
                        function ($item) use ($selectedModelClass) {
                            return in_array($item, constant($selectedModelClass . '::CAN_SELECT'));
                        }
                    );
                } else {
                    unset($selectedFields[$selectedModel]);
                }
            }
        } else {
            $selectedFields = [$resourceName => $selectable];
        }

        // Eager loading
        foreach ($selectedFields as $selectedResource => $selectedFieldList) {
            if ($selectedResource !== $resourceName) {
                // The column designated as the id of the model that should be eager loaded
                // should be selected in the main query
                $selectedResourceRelationshipId = $selectedResource . '_id';
                if (!in_array($selectedResourceRelationshipId, $selectedFields[$resourceName])) {
                    $selectedFields[$resourceName] [] = $selectedResourceRelationshipId;
                }
                // The id must be present in column list of eager loaded models
                if (!in_array('id', $selectedFieldList)) {
                    $selectedFieldList [] = 'id';
                }
                $relations = $selectedResource . ':' . implode(',', $selectedFieldList);
                $query->with($relations);
            }
        }

        // Selecting required fields (excepting the eager loaded relationships)
        $query->select($selectedFields[$resourceName]);

        // Paginate the results
        $entities = $query->paginate($httpRequest->per_page);

        // Add the existing query parameter to the current/next/previous page url
        $entities->appends($httpRequest->query());

        return array_merge(
            $entities->toArray(),
            [
                'sortable_by' => $sortableBy,
            ]
        );
    }
}
