<?php

namespace App\Http\Controllers\Unauthenticated;

use App\City;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $httpRequest = request();

        $entities = City::paginate($httpRequest->per_page);
        $entities->appends($httpRequest->query());

        return $entities;
    }

    public function show($id)
    {
        return City::find($id);
    }
}
