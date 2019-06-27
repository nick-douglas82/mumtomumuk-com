<?php

namespace App\Search\Filters;

use Illuminate\Database\Eloquent\Collection;

class Time
{
    public static function apply($builder, $value)
    {
        return $builder->filter(function ($collection, $key) use ($value) {
            return in_array($collection->event_at->format('a'), $value);
        });
    }
}
