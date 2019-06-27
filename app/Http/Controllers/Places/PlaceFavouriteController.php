<?php

namespace App\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use App\Place;
use App\Site;
use Illuminate\Http\Request;

class PlaceFavouriteController extends Controller
{
    /**
     * Store a new favourite in the database.
     *
     * @param  Directory $place
     */
    public function store(Site $site, Place $place)
    {
        $place->favourite($place);
    }

    /**
     * Delete the favourite.
     *
     * @param Diretory $place
     */
    public function destroy(Site $site, Place $place)
    {
        $place->unfavourite($place);
    }
}
