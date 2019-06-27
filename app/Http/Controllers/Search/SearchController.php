<?php

namespace App\Http\Controllers\Search;

use App\AfterSchoolClub;
use App\BabyToddlerGroup;
use App\Event;
use App\Http\Controllers\Controller;
use App\Site;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchEvents(Site $site, $term)
    {
        return Event::whereHas('tags', function ($query) use ($term) {
            $query->where('slug', $term);
        })->orWhere('title', 'like', '%' . str_replace('-', ' ', $term) . '%')->get();
    }

    public function searchBabyToddler(Site $site, $term)
    {
        return BabyToddlerGroup::whereHas('tags', function ($query) use ($term) {
            $query->where('slug', $term);
        })->orWhere('title', 'like', '%' . str_replace('-', ' ', $term) . '%')->get();
    }

    public function searchAfterSchool(Site $site, $term)
    {
        return AfterSchoolClub::whereHas('tags', function ($query) use ($term) {
            $query->where('slug', $term);
        })->orWhere('title', 'like', '%' . str_replace('-', ' ', $term) . '%')->get();
    }

    public function searchTag(Site $site, Request $request)
    {
        $queryRequest = $request['q'];

        $collection = Tag::where('tag_type', BabyToddlerGroup::class)
            ->orWhere('tag_type', AfterSchoolClub::class)
            ->orWhere('tag_type', Event::class)
            ->get();

        return $collection->filter(function ($value, $key) use ($queryRequest) {
            return str_contains(strtolower($value->name), strtolower($queryRequest));
        })->flatten(1);
    }
}
