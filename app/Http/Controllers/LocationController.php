<?php

namespace App\Http\Controllers;

use App\Event;
use App\Feature;
use App\Page;
use App\RebeccaReview;
use App\Site;
use App\Place;
use Illuminate\Http\Request;
use App\Directory;

class LocationController extends Controller
{
    /**
     * Show the location's homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $page       = Page::whereSlug('/')->firstOrFail();

        $seo        = $page->seo()->first();

        $adverts    = $page->adverts()->get()->groupBy('ad_type')->toArray();

        $events     = Event::featured(3);

        $reviews    = RebeccaReview::featured(2);

        $activities = Place::featured(3);

        $services   = Directory::featured(3);

        $site       = $site->name;

        return view('home', compact('reviews', 'events', 'activities', 'services', 'site', 'adverts', 'seo', 'page'));
    }
}
