<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    const CAN_SELECT = ['id', 'name', 'type', 'coords', 'county_id'];
    const SORTABLE_BY = ['id', 'name', 'type', 'county_id'];

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}
