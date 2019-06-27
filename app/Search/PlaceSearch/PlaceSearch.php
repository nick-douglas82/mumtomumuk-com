<?php
namespace App\Search\PlaceSearch;

use App\Place;
use App\Search\Filters\Postcode;
use App\Search\Filters\SearchQuery;
use App\Search\Filters\Tag;
use App\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PlaceSearch
{
    public static function apply(Request $filters, Site $site)
    {
        $filtersCollection = collect($filters);

        $query = (new Place)->newQuery()->orderBy('title', 'asc');

        if ($filtersCollection->has('tags')) {
            $query = Tag::apply($query, $filters->tags);
        }

        return $query instanceof Collection ? static::paginateCollectionResults($query) : static::paginateResults($query, $site);
    }

    private static function paginateResults(Builder $query, $site)
    {
        return $query->paginate(10);
    }
}
