<?php

namespace App\Http\Controllers\Directory;

use App\Directory;
use App\Http\Controllers\Controller;
use App\Review;
use App\Site;
use Illuminate\Http\Request;

class DirectoryReviewController extends Controller
{
    public function store(Site $site, Directory $directory, Request $request)
    {
        $directory->createReview($request, $directory);
    }

    public function update(Site $site, Review $review, Request $request)
    {
        $review->setConnection(str_replace('-', '_', $site->slug));
        $review->body = $request->body;
        $review->save();
    }
}
