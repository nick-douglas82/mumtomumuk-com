<?php

namespace App\Http\Controllers\HolidayIdeas;

use App\HolidayIdeas;
use App\Http\Controllers\Controller;
use App\Site;
use App\Tag;
use App\Category;
use Illuminate\Http\Request;
use App\Page;

class HolidayIdeasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $blogTags = HolidayIdeas::categories();

        $page = Page::whereSlug('holiday-ideas')->firstOrFail();

        $seo = $page->seo()->first();

        $adverts = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('holiday-ideas.index', compact('blogTags', 'adverts', 'seo', 'page'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, $holidayidea)
    {
        $holidayidea = HolidayIdeas::whereSlug($holidayidea)
                                    ->with('comments.user', 'user')
                                    ->first();

        $adverts = $holidayidea->adverts()->get()->groupBy('ad_type')->toArray();

        $seo = $holidayidea->seo()->first();

        return view('holiday-ideas.show', compact('holidayidea', 'adverts', 'seo'));
    }
}
