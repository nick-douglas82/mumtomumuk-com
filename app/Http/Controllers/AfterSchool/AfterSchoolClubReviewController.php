<?php

namespace App\Http\Controllers\AfterSchool;

use App\AfterSchoolClub;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;

class AfterSchoolClubReviewController extends Controller
{
    public function store(Site $site, AfterSchoolClub $afterschoolclub, Request $request)
    {
        $afterschoolclub->createReview($request, $afterschoolclub);
    }

    public function update(Site $site, Review $review, Request $request)
    {
        $review->setConnection(str_replace('-', '_', $site->slug));
        $review->body = $request->body;
        $review->save();
    }
}
