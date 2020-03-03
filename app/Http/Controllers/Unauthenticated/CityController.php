<?php

namespace App\Http\Controllers\Unauthenticated;

use App\City;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        return City::all();
    }

    public function show($id)
    {
        return City::find($id);
    }
}
