<?php

namespace App\Http\Controllers\Unauthenticated;

use App\City;
use App\Http\Controllers\ApiIndexTrait;
use App\Http\Controllers\Controller;
use App\Http\Converters\Http\RequestConverter;

class CityController extends Controller
{
    use ApiIndexTrait;
    /**
     * @var RequestConverter
     */
    private $requestConverter;

    public function __construct(RequestConverter $requestConverter)
    {
        $this->requestConverter = $requestConverter;
    }

    public function index()
    {
        return $this->apiIndex($this->requestConverter, City::class);
    }

    public function show($id)
    {
        return City::find($id);
    }
}
