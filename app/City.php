<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    const SORTABLE_BY = ['id', 'name', 'slug', 'type', 'county_id'];

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}
