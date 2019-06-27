<?php

namespace App\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use App\Place;
use App\Site;
use Illuminate\Http\Request;

class PlaceReviewController extends Controller
{
    public function store(Site $site, Place $place, Request $request)
    {
        $place->createReview($request, $place);
    }

    public function update(Site $site, Review $review, Request $request)
    {
        $review->setConnection(str_replace('-', '_', $site->slug));
        $review->body = $request->body;
        $review->save();
    }
}
