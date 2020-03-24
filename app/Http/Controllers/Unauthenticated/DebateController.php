<?php

namespace App\Http\Controllers\Unauthenticated;

use App\Debate;
use App\Http\Controllers\Controller;
use OctavianParalescu\ApiController\Controllers\ApiIndexTrait;
use OctavianParalescu\ApiController\Converters\RequestConverter;

class DebateController extends Controller
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
        return $this->apiIndex($this->requestConverter, Debate::class);
    }

    public function show($id)
    {
        return Debate::find($id);
    }
}
