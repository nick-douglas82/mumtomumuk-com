<?php

namespace App\Http\Controllers\Places;

use App\Address;
use App\Http\Controllers\Controller;
use App\Place;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Page;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::whereSlug('places-to-go')->firstOrFail();

        $seo = $page->seo()->first();

        $adverts = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('places.index', compact('adverts', 'seo', 'page'));
    }

    /**
     * Show the requested resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, Place $place)
    {
        $adverts = $place->adverts()->get()->groupBy('ad_type')->toArray();

        $seo = $place->seo()->first();

        return view('places.show', compact('place', 'adverts', 'seo'));
    }

    public function all() {

        return Cache::remember('places.all', 60 * 60, function () {
            return Place::all();
        });
    }

    public function byRadius($postcode, $distance) {

        $address     = New Address;
        $coordinates = $address->convertPostcode($postcode);

        return Place::closeTo($coordinates['lat'], $coordinates['long'], $distance);
    }
}
