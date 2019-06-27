<?php

namespace App\Http\Controllers;

use App\Page;
use App\Site;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::all();
        return view('welcome', compact('sites'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, $page)
    {
        $page    = Page::whereSlug($page)->firstOrFail();

        $seo     = $page->seo()->first();

        $adverts = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('generic.show', compact('page', 'adverts', 'seo'));
    }
}
