<?php
namespace App\Http\Controllers\Directory;

use App\Site;
use App\Directory;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\DirectorySearch\DirectorySearch;
use Illuminate\Pagination\LengthAwarePaginator;

class DirectorySearchController extends Controller
{
    public function search(Request $request, Site $site)
    {
        return DirectorySearch::apply($request, $site);
    }

    public function query(Request $request, Site $site)
    {
        return Directory::where('title', 'like', '%' . $request->q . '%')
                        ->get();
    }
}
