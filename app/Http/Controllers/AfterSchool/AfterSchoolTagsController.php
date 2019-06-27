<?php

namespace App\Http\Controllers\AfterSchool;

use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\AfterSchoolClub;

class AfterSchoolTagsController extends Controller
{
    public function all(Site $site) {
        return AfterSchoolClub::with('tags')->get()->map(function ($afterschool, $key) {
            return $afterschool->tags->map(function ($tag, $key) {
                return ["slug" => $tag->slug, "name" => $tag->name, "ref_id" => $tag->id];
            });
        })->flatten(1)->unique('name')->keyBy('slug')->sortBy('slug')->toJson();
    }
}
