<?php

namespace App\Http\Controllers\BabyToddler;

use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\BabyToddlerGroup;

class BabyToddlerGroupTagsController extends Controller
{
    public function all(Site $site) {

        return BabyToddlerGroup::with('tags')->get()->map(function ($babytoddler, $key) {
            return $babytoddler->tags->map(function ($tag, $key) {
                return ["slug" => $tag->slug, "name" => $tag->name, "ref_id" => $tag->id];
            });
        })->flatten(1)->unique('name')->keyBy('slug')->sortBy('slug')->toJson();
    }
}
