<?php

namespace App\Http\Controllers\AskMum;

use App\AskMum;
use App\Http\Controllers\Controller;
use App\Page;
use App\Site;
use Illuminate\Http\Request;

class AskMumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $questions = AskMum::all();
        $groups    = $questions->groupBy('group')->toArray();

        $page      = Page::whereSlug('askmum')->firstOrFail();

        $seo       = $page->seo()->first();

        $adverts   = $page->adverts()->get()->groupBy('ad_type')->toArray();

        return view('askmum.index', compact('groups', 'adverts', 'seo', 'page'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, $question)
    {
        $askmum  = AskMum::whereSlug($question)->first();

        $adverts = $askmum->adverts()->get()->groupBy('ad_type')->toArray();

        $seo     = $askmum->seo()->first();

        return view('askmum.show', compact('askmum', 'adverts', 'seo'));
    }
}
