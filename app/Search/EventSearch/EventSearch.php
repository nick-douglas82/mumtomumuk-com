<?php
namespace App\Search\EventSearch;

use App\Event;
use App\Search\Filters\Date;
use App\Search\Filters\Tag;
use App\Search\Filters\When;
use App\Search\Filters\SearchQuery;
use App\Search\Filters\Postcode;
use App\Site;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EventSearch
{
    public static function apply(Request $filters, Site $site)
    {
        $filtersCollection = collect($filters);

        $query = (new Event)->newQuery()->whereDate('event_at', '>=', Carbon::now())->orderBy('event_at', 'asc');

        if ($filtersCollection->has('when')) {
            $query = When::apply($query, $filters->when);
        }

        if ($filtersCollection->has('date')) {
            $query = Date::apply($query, $filters->date);
        }

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
