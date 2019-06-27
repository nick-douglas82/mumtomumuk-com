<?php

namespace App\Http\Controllers\Events;

use App\Event;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;

class EventFavouriteController extends Controller
{
    /**
     * Store a new favorite in the database.
     *
     * @param  Event $event
     */
    public function store(Site $site, Event $event)
    {
        $event->favourite($event);
    }

    /**
     * Delete the favorite.
     *
     * @param Event $event
     */
    public function destroy(Site $site, Event $event)
    {
        $event->unfavourite($event);
    }
}
