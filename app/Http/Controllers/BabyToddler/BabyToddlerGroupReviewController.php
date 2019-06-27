<?php

namespace App\Http\Controllers\BabyToddler;

use App\BabyToddlerGroup;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;

class BabyToddlerGroupReviewController extends Controller
{
    public function store(Site $site, BabyToddlerGroup $babytoddlergroup, Request $request)
    {
        $babytoddlergroup->createReview($request, $babytoddlergroup);
    }

    public function update(Site $site, Review $review, Request $request)
    {
        $review->setConnection(str_replace('-', '_', $site->slug));
        $review->body = $request->body;
        $review->save();
    }
}
