<?php

namespace App\Http\Controllers\Unauthenticated;

use App\County;
use App\Http\Controllers\Controller;

class CountyController extends Controller
{
    public function index()
    {
        return County::all();
    }

    public function show($id)
    {
        return County::find($id);
    }
}
