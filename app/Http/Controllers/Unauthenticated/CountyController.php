<?php

namespace App\Http\Controllers\Unauthenticated;

use App\County;
use App\Http\Controllers\Controller;

class CountyController extends Controller
{
    public function index()
    {
        return $this->apiIndex(County::class);
    }

    public function show($id)
    {
        return County::find($id);
    }
}
