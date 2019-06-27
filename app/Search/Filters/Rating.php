<?php

namespace App\Search\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Rating
{
    public static function apply($builder, $value)
    {
        return $builder->filter(function ($builder, $key) use ($value) {
            if (count($value) == 1) {
                return $builder->averageRating() >= implode(',', $value);
            }
            else if(count($value) > 1) {
                foreach ($value as $rating) {
                    return $builder->averageRating() >= $rating;
                }
            }
        });
    }
}
