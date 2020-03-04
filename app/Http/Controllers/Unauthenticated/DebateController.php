<?php

namespace App\Http\Controllers\Unauthenticated;

use App\Debate;
use App\Http\Controllers\Controller;

class DebateController extends Controller
{
    public function index()
    {
        $httpRequest = request();

        $entities = Debate::paginate($httpRequest->per_page);
        $entities->appends($httpRequest->query());

        return $entities;
    }

    public function show($id)
    {
        return Debate::find($id);
    }
}
