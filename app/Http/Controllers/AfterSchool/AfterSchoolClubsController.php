<?php

namespace App\Http\Controllers\AfterSchool;

use App\AfterSchoolClub;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;
use App\Page;

class AfterSchoolClubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::whereSlug('4-plus-activities')->firstOrFail();

        $seo = $page->seo()->first();

        $adverts = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('after-school-clubs.index', compact('adverts', 'seo', 'page'));
    }

    /**
     * Show the requested resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, AfterSchoolClub  $afterschoolclub)
    {
        $adverts = $afterschoolclub->adverts()->get()->groupBy('ad_type')->toArray();

        $seo = $afterschoolclub->seo()->first();

        return view('after-school-clubs.show', compact('afterschoolclub', 'adverts', 'seo'));
    }
}
