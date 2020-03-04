<?php

namespace App\Http\Controllers\Unauthenticated;

use App\County;
use App\Http\Controllers\Controller;

class CountyController extends Controller
{
    public function index()
    {
        $httpRequest = request();

        $entities = County::paginate($httpRequest->per_page);
        $entities->appends($httpRequest->query());

        return $entities;
    }

    public function show($id)
    {
        return County::find($id);
    }
}
