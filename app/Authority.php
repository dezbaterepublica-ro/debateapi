<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
