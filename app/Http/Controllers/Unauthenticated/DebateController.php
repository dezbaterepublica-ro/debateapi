<?php

namespace App\Http\Controllers\Unauthenticated;

use App\Debate;
use App\Http\Controllers\Controller;

class DebateController extends Controller
{
    public function index()
    {
        return Debate::all();
    }

    public function show($id)
    {
        return Debate::find($id);
    }
}
