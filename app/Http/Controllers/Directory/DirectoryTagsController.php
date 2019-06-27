<?php

namespace App\Http\Controllers\Directory;

use App\Tag;
use App\Directory;
use App\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;


class DirectoryTagsController extends Controller
{
    public function all(Site $site)
    {
        $tags = Cache::remember('mk-directory-tags', 1440, function () {
            $tagIds = \DB::table('taggables')
                ->distinct()
                ->select('tag_id')
                ->where('taggables_type', Directory::class)
                ->get()
                ->pluck('tag_id');

            return Tag::whereIn('id', $tagIds)->get()->sortBy('slug')->values()->all();
        });

        return response()->json($tags);

        // return Directory::with('tags')->get()->map(function ($directory, $key) {
        //     return $directory->tags->map(function ($tag, $key) {
        //         return ["slug" => $tag->slug, "name" => $tag->name, "ref_id" => $tag->id];
        //     });
        // })->flatten(1)->unique('name')->keyBy('slug')->sortBy('slug')->toJson();
    }
}
