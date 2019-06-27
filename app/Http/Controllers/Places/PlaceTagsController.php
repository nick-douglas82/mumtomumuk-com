<?php

namespace App\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use App\Site;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PlaceTagsController extends Controller
{
    public function all(Site $site) {

        return Place::with('tags')->get()->map(function ($event, $key) {
            return $event->tags->map(function ($tag, $key) {
                return ["slug" => $tag->slug, "name" => $tag->name, "ref_id" => $tag->id];
            });
        })->flatten(1)->unique('name')->keyBy('slug')->sortBy('slug')->toJson();
    }
}
