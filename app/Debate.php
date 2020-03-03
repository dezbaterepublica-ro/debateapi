<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debate extends Model
{
    public function authority()
    {
        return $this->belongsTo(Authority::class);
    }
}
