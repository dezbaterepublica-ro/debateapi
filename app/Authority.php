<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Authority extends Model
{
    const CAN_SELECT = ['id', 'name', 'slug', 'county_id', 'city_id'];
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Returns all the categories of the authority,
     * first is the most specific, last is the least specific
     * @return Collection
     */
    public function categories()
    {
        $categories = new Collection();
        /** @var Category $currentCategory */
        $currentCategory = $this->category;
        do {
            $categories->push($currentCategory);
        } while ($currentCategory = $currentCategory->parentCategory());

        return $categories;
    }
}
