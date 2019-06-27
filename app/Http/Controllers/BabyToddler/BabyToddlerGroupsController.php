<?php

namespace App\Http\Controllers\BabyToddler;

use App\BabyToddlerGroup;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Page;

class BabyToddlerGroupsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('database');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::whereSlug('baby-toddler-groups')->firstOrFail();

        $seo = $page->seo()->first();

        $adverts = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('baby-toddler.index', compact('adverts', 'seo', 'page'));
    }

    /**
     * Show the requested resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, BabyToddlerGroup  $babytoddlergroup)
    {
        $adverts = $babytoddlergroup->adverts()->get()->groupBy('ad_type')->toArray();

        $seo = $babytoddlergroup->seo()->first();

        return view('baby-toddler.show', compact('babytoddlergroup', 'adverts', 'seo'));
    }
}
