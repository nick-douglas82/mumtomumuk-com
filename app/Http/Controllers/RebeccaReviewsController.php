<?php

namespace App\Http\Controllers;

use App\RebeccaReview;
use App\Site;
use Illuminate\Http\Request;
use App\Page;

class RebeccaReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $blogTags = RebeccaReview::categories();
        $posts    = RebeccaReview::orderBy('created_at', 'desc')->paginate(10);
        $page     = Page::whereSlug('blog/rebecca-reviews')->firstOrFail();
        $seo      = $page->seo()->first();
        $adverts  = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('rebecca-reviews.index', compact('posts', 'blogTags', 'adverts', 'page', 'seo'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, RebeccaReview $rebeccareview)
    {
        return view('rebecca-reviews.show', [
            'rebeccareview' => $rebeccareview,
            'adverts'       => $rebeccareview->adverts()->get()->groupBy('ad_type')->toArray(),
            'seo'           => $rebeccareview->seo()->first(),
            'comments'      => $rebeccareview->comments()->whereNotNull('approved_at')->orderBy('approved_at', 'desc')->get()
        ]);
    }
}
