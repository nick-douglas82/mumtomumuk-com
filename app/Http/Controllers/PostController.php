<?php

namespace App\Http\Controllers;

use App\Post;
use App\Site;
use App\Page;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $page     = Page::whereSlug('blog/posts')->firstOrFail();

        return view('posts.index', [
            'blogTags' => Post::categories(),
            'posts'    => Post::orderBy('created_at', 'desc')->get(),
            'page'     => $page,
            'seo'      => $page->seo()->first(),
            'adverts'  => $page->adverts()->get()->groupBy('ad_type')->toArray()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, Post $post)
    {
        return view('posts.show', [
            'post'     => $post,
            'adverts'  => $post->adverts()->get()->groupBy('ad_type')->toArray(),
            'seo'      => $post->seo()->first(),
            'comments' => $post->comments()->whereNotNull('approved_at')->orderBy('approved_at', 'desc')->get()
        ]);
    }
}
