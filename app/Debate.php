<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debate extends Model
{
    use SoftDeletes;
    const SORTABLE_BY = [
        'id',
        'title',
        'slug',
        'type',
        'start_date',
        'end_date',
        'interest',
        'authority_id',
        'created_at',
        'updated_at',
    ];

    public function authority()
    {
        return $this->belongsTo(Authority::class);
    }
}
