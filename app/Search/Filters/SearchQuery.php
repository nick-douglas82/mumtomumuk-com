<?php

namespace App\Search\Filters;

use Illuminate\Database\Eloquent\Builder;

class SearchQuery
{
    public static function apply($builder, $value)
    {
        return $builder->where('title', 'like', '%' . $value . '%');
    }
}
