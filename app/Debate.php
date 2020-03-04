<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debate extends Model
{
    use SoftDeletes;

    public function authority()
    {
        return $this->belongsTo(Authority::class);
    }
}
