<?php

namespace App\Http\Controllers;

use App\Post;
use App\Site;
use Illuminate\Http\Request;

class PostSearchController extends Controller
{
    public function index(Site $site, Request $request)
    {
        return Post::orderBy('created_at', 'desc')->paginate(10);
    }

    public function tags(Site $site, Request $request)
    {
        $tag     = $request->tag;
        $query   = Post::whereNotNull('created_at');

        if ($tag != 0) {
            return $query->whereHas('tags', function ($tagQuery) use ($tag) {
                $tagQuery->where('id', $tag);
            })->orderBy('created_at', 'desc')->paginate(10);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function category(Site $site, Request $request)
    {
        $category = $request->category;
        $query = (new Post)->newQuery();

        if ($category != 0) {
            return $query->whereHas('category', function ($categoryQuery) use ($category) {
                $categoryQuery->where('id', $category);
            })->orderBy('created_at', 'desc')->paginate(10);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
}
