<?php

namespace App\Search\Filters;

use Illuminate\Database\Eloquent\Builder;

class Tag
{
    public static function apply($builder, $value)
    {
        collect($value)->each(function ($tag) use ($builder) {
            $builder->whereHas('tags', function ($tagQuery) use ($tag) {
                $tagQuery->where('slug', $tag);
            });
        });
        // collect($value)->each(function ($tagId) use ($builder) {
        //     $builder->whereHas('tags', function ($tagQuery) use ($tagId) {
        //         $tagQuery->where('id', $tagId);
        //     });
        // });

        return $builder;
    }
}
