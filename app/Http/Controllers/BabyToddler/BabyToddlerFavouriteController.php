<?php

namespace App\Http\Controllers\BabyToddler;

use App\BabyToddlerGroup;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;

class BabyToddlerFavouriteController extends Controller
{
    /**
     * Store a new favorite in the database.
     *
     * @param  Event $babytoddlergroup
     */
    public function store(Site $site, BabyToddlerGroup $babytoddlergroup)
    {
        $babytoddlergroup->favourite($babytoddlergroup);
    }

    /**
     * Delete the favorite.
     *
     * @param Event $babytoddlergroup
     */
    public function destroy(Site $site, BabyToddlerGroup $babytoddlergroup)
    {
        $babytoddlergroup->unfavourite($babytoddlergroup);
    }
}
