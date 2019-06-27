<?php
namespace App\Http\Controllers\Places;

use App\Site;
use App\Place;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\PlaceSearch\PlaceSearch;

class PlaceSearchController extends Controller
{
    public function search(Request $request, Site $site)
    {
        return PlaceSearch::apply($request, $site);
    }

    public function query(Request $request, Site $site)
    {
        return Place::where('title', 'like', '%' . $request->q . '%')->get();
    }
}
