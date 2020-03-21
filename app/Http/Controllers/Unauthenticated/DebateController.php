<?php

namespace App\Http\Controllers\Unauthenticated;

use App\Debate;
use App\Http\Controllers\ApiIndexTrait;
use App\Http\Controllers\Controller;
use App\Http\Converters\Http\RequestConverter;

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
