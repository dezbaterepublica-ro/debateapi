<?php

namespace App\Http\Controllers\Unauthenticated;

use App\County;
use App\Http\Controllers\Controller;
use OctavianParalescu\ApiController\Controllers\ApiIndexTrait;
use OctavianParalescu\ApiController\Converters\RequestConverter;

class CountyController extends Controller
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
        return $this->apiIndex($this->requestConverter, County::class);
    }

    public function show($id)
    {
        return County::find($id);
    }
}
