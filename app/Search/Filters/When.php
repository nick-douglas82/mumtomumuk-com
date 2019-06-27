<?php

namespace App\Search\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class When
{
    public static function apply($builder, $value)
    {
        collect($value)->each(function ($dateId) use ($value, $builder) {
            // 0 - today
            if ($dateId == 'today') {
                $builder->where('event_at', '>=', Carbon::today()->startOfDay());
                $builder->where('event_at', '<=', Carbon::today()->endOfDay());
            }

            // 1 - Tomorrow
            if ($dateId == 'tomorrow') {

                if (count($value) > 1) {
                    $builder->orWhere('event_at', '>=', Carbon::tomorrow()->startOfDay());
                    $builder->where('event_at', '<=', Carbon::tomorrow()->endOfDay());
                }
                else {
                    $builder->where('event_at', '>=', Carbon::tomorrow()->startOfDay());
                    $builder->where('event_at', '<=', Carbon::tomorrow()->endOfDay());
                }
            }

            // 2 - This weekend
            if ($dateId == 'this-weekend') {
                if (count($value) > 1) {
                    $builder->orWhere('event_at', '>=', Carbon::today()->startOfWeek()->addDay(5)->startOfDay());
                    $builder->where('event_at', '<=', Carbon::today()->startOfWeek()->addDay(6)->endOfDay());
                }
                else {
                    $builder->where('event_at', '>=', Carbon::today()->startOfWeek()->addDay(5)->startOfDay());
                    $builder->where('event_at', '<=', Carbon::today()->startOfWeek()->addDay(6)->endOfDay());
                }
            }
        });

        return $builder;
    }
}
