<?php

namespace App\Http\Controllers\Tracking;

use App\Site;
use App\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TrackingController extends Controller
{
    public function searchTerm(Site $site, Request $request)
    {

        $requests = $request->all();

        $tracking = new Tracking;

        $tracking->user_id       = (Auth::check()) ? Auth::id() : NULL;
        $tracking->client_ip     = $request->ip();
        $tracking->type          = $requests['type'];
        $tracking->from_page     = $requests['url'];
        $tracking->gathered_data = serialize(['term' => $requests['term']]);

        $tracking->save();

        return response()->json([
            'status' => 'success'
        ], 201);
    }
}
