<?php

namespace App\Http\Controllers\Directory;

use App\Directory;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Str;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('directory.index', [
            'page'     => $page = Page::whereSlug('directory')->firstOrFail(),
            'adverts'  => $page->adverts()->get()->groupBy('ad_type')->toArray(),
            'seo'      => $page->seo()->first()
        ]);
    }

    /**
     * Show the requested resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, Directory $directory)
    {
        $adverts = $directory->adverts()->get()->groupBy('ad_type')->toArray();

        $seo = $directory->seo()->first();

        return view('directory.show', compact('directory', 'adverts', 'seo'));
    }
}
