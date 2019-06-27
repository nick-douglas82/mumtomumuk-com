<?php

namespace App\Search\Filters;

use App\Address;
use Illuminate\Database\Eloquent\Builder;

class Postcode
{
    public static function apply(Builder $builder, $value, $param)
    {
        $address     = New Address;
        $coordinates = $address->convertPostcode($value);

        return $builder->closeTo($coordinates['lat'], $coordinates['long'], $param);
    }
}
