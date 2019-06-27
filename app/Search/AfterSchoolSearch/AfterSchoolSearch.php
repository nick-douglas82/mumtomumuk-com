<?php
namespace App\Search\AfterSchoolSearch;

use App\Site;
use App\AfterSchoolClub;
use App\Search\Filters\Day;
use App\Search\Filters\Tag;
use App\Search\Filters\Time;
use Illuminate\Http\Request;
use App\Search\Filters\Postcode;
use App\Search\Filters\SearchQuery;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AfterSchoolSearch
{
    public static function apply(Request $filters, Site $site)
    {
        $filtersCollection = collect($filters);

        $query = (new AfterSchoolClub)->newQuery()->orderBy('title', 'asc');

        if ($filtersCollection->has('tags')) {
            $query = Tag::apply($query, $filters->tags);
        }

        return $query instanceof Collection ? static::paginateCollectionResults($query) : static::paginateResults($query, $site);
    }

    private static function paginateResults(Builder $query, $site)
    {
        return $query->paginate(10);
    }

    private static function paginateCollectionResults($items, $perPage = 10, $page = null, $options = [])
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
