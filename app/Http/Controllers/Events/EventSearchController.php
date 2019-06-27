<?php
namespace App\Http\Controllers\Events;

use App\Site;
use App\Event;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\EventSearch\EventSearch;

class EventSearchController extends Controller
{

    public function search(Request $request, Site $site)
    {
        return EventSearch::apply($request, $site);
    }

    public function query(Request $request, Site $site)
    {
        return Event::where('title', 'like', '%' . $request->q . '%')->get();
    }
}
