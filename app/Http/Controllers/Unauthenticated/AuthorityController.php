<?php

namespace App\Http\Controllers\Unauthenticated;

use App\Authority;
use App\Http\Controllers\ApiIndexTrait;
use App\Http\Controllers\Controller;
use App\Http\Converters\Http\RequestConverter;

class AuthorityController extends Controller
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
        return $this->apiIndex($this->requestConverter, Authority::class);
    }

    public function show($id)
    {
        return Authority::find($id);
    }
}
