<?php

namespace App\Http\Controllers;

use App\Post;
use App\Site;
use App\RebeccaReview;
use Illuminate\Http\Request;
use App\Page;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $reviewsCount      = RebeccaReview::count();
        $reviewsCollection = RebeccaReview::limit(4)->orderBy('created_at', 'asc')->get();
        $postsCount        = Post::count();
        $postsCollection   = Post::limit(4)->orderBy('created_at', 'desc')->get();

        $page = Page::whereSlug('blog')->firstOrFail();

        $seo = $page->seo()->first();

        $adverts = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('blog.index', compact('postsCollection', 'postsCount', 'reviewsCollection', 'reviewsCount', 'adverts', 'seo', 'page'));
    }
}
