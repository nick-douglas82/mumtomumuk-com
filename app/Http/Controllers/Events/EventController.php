<?php

namespace App\Http\Controllers\Events;

use App\Event;
use App\Http\Controllers\Controller;
use App\Place;
use App\Site;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;
use App\Page;

class EventController extends Controller
{
    public function index()
    {
        $page    = Page::whereSlug('events')->firstOrFail();

        $seo     = $page->seo()->first();

        $adverts = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('events.index', compact('adverts', 'seo', 'page'));
    }

    /**
     * Show the requested resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, Event $event)
    {
        $adverts = $event->adverts()->get()->groupBy('ad_type')->toArray();

        $seo = $event->seo()->first();

        return view('events.show', compact('event', 'adverts', 'seo'));
    }

    /**
     * Delete the favorite.
     *
     * @param Event $event
     */
    // public function destroy(Event $event)
    // {
    //     $event->unfavourite();
    // }
}
