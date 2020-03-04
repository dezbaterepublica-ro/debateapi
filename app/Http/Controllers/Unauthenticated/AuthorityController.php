<?php

namespace App\Http\Controllers\Unauthenticated;

use App\Authority;
use App\Http\Controllers\Controller;

class AuthorityController extends Controller
{
    public function index()
    {
        $httpRequest = request();

        $entities = Authority::paginate($httpRequest->per_page);
        $entities->appends($httpRequest->query());

        return $entities;
    }

    public function show($id)
    {
        return Authority::find($id);
    }
}
