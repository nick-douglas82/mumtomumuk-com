<?php

namespace App\Search\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Date
{
    public static function apply($builder, $value)
    {
        if (isset($param) && count($param) >= 1) {
            $builder->orWhere('event_at', '>=', Carbon::parse($value)->startOfDay());
            $builder->where('event_at', '<=', Carbon::parse($value)->endOfDay());
        }
        else {
            $builder->where('event_at', '>=', Carbon::parse($value)->startOfDay());
            $builder->where('event_at', '<=', Carbon::parse($value)->endOfDay());
        }

        return $builder;
    }
}
