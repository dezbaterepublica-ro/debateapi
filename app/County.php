<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    const CAN_SELECT = ['id', 'name', 'type',];
    const SORTABLE_BY = ['id', 'name', 'slug', 'type'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
