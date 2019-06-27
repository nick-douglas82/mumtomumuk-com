<?php

namespace App\Search\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Day
{
    public static function apply($builder, $value)
    {
        return $builder->filter(function ($builder, $key) use ($value) {
            return in_array(strtolower($builder->event_at->format('l')), $value);
        });
    }
}
