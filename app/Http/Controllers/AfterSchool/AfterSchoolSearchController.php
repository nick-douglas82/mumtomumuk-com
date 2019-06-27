<?php
namespace App\Http\Controllers\AfterSchool;

use App\Address;
use App\AfterSchoolClub;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Search\AfterSchoolSearch\AfterSchoolSearch;
use App\Site;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AfterSchoolSearchController extends Controller
{
    public function search(Request $request, Site $site)
    {
        return AfterSchoolSearch::apply($request, $site);
    }

    public function query(Request $request, Site $site)
    {
        return AfterSchoolClub::where('title', 'like', '%' . $request->q . '%')
                                ->get();
    }
}
