<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
Class Address
{
    /**
     * Simple helper to convert postcode to latitude and longitudes
     *
     * @return \Illuminate\Http\Response
     */
    public function convertPostcode($postcode)
    {
        return Cache::remember('places.' . $postcode, 60 * 60, function () use ($postcode) {
            $coordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($postcode) . '&key=' . env('GOOGLE_API'));
            $coordinates = json_decode($coordinates);

            return [
                'long' => $coordinates->results[0]->geometry->location->lng,
                'lat'  => $coordinates->results[0]->geometry->location->lat,
            ];
        });
    }
}
