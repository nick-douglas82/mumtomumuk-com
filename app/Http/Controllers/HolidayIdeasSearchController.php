<?php

namespace App\Http\Controllers;

use App\Site;
use App\HolidayIdeas;
use Illuminate\Http\Request;

class HolidayIdeasSearchController extends Controller
{
    public function index(Site $site, Request $request)
    {
        return HolidayIdeas::paginate(10);
    }

    public function category(Site $site, Request $request)
    {
        $category = $request->category;
        $query = (new HolidayIdeas())->newQuery();

        if ($category != 0) {
            return $query->whereHas('category', function ($categoryQuery) use ($category) {
                $categoryQuery->where('id', $category);
            })->paginate(10);
        }

        return $query->paginate(10);
    }
}
