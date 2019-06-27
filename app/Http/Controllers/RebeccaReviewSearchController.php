<?php

namespace App\Http\Controllers;

use App\RebeccaReview;
use App\Site;
use App\Tag;
use Illuminate\Http\Request;

class RebeccaReviewSearchController extends Controller
{
    public function index(Site $site)
    {
        return RebeccaReview::orderBy('created_at', 'desc')->paginate(10);
    }

    public function category(Site $site, Request $request)
    {
        $category = $request->category;
        $query    = (new RebeccaReview)->newQuery();

        if ($category != 0) {
            return $query->whereHas('category', function ($categoryQuery) use ($category) {
                $categoryQuery->where('id', $category);
            })->orderBy('created_at', 'desc')->paginate(10);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
}
