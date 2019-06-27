<?php
namespace App\Http\Controllers\BabyToddler;

use App\BabyToddlerGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Search\BabyToddlerSearch\BabyToddlerSearch;
use App\Site;
use Illuminate\Http\Request;

class BabyToddlerSearchController extends Controller
{
    public function search(Request $request, Site $site)
    {
        return BabyToddlerSearch::apply($request, $site);
    }

    public function query(Request $request, Site $site)
    {
        return BabyToddlerGroup::on('milton_keynes')->where('title', 'like', '%' . $request->q . '%')
                                ->get();
    }
}
