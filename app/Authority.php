<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    const SORTABLE_BY = ['id', 'name', 'slug', 'county_id', 'city_id'];

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function debates()
    {
        return $this->hasMany(Debate::class);
    }
}
