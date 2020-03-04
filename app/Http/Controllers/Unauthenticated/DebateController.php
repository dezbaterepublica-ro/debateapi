<?php

namespace App\Http\Controllers\Unauthenticated;

use App\Debate;
use App\Http\Controllers\Controller;

class DebateController extends Controller
{
    public function index()
    {
        return $this->apiIndex(Debate::class);
    }

    public function show($id)
    {
        return Debate::find($id);
    }
}
