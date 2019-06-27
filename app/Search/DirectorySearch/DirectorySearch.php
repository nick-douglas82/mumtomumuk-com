<?php
namespace App\Search\DirectorySearch;

use App\Directory;
use App\Search\Filters\Postcode;
use App\Search\Filters\Rating;
use App\Search\Filters\SearchQuery;
use App\Search\Filters\Tag;
use App\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class DirectorySearch
{
    // public static function apply(Request $filters, Site $site)
    // {
    //     $filtersCollection = collect($filters);

    //     $query = (new Directory)->newQuery()->orderBy('title', 'asc');

    //     if ($filtersCollection->has('filters')) {
    //         $query = Tag::apply($query, $filters->filters);
    //     }

    //     return $query instanceof Collection ? static::paginateCollectionResults($query) : static::paginateResults($query, $site);
    // }

    public static function apply(Request $filters, Site $site)
    {
        $filtersCollection = collect($filters);

        $query = (new Directory)->newQuery()->orderBy('title', 'asc');

        if ($filtersCollection->has('tags')) {
            $query = Tag::apply($query, $filters->tags);
        }

        return $query instanceof Collection ? static::paginateCollectionResults($query) : static::paginateResults($query, $site);
    }

    private static function paginateResults(Builder $query)
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
