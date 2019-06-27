<?php

namespace App\Http\Controllers\AfterSchool;

use App\AfterSchoolClub;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;

class AfterSchoolFavouriteController extends Controller
{
    /**
     * Store a new favorite in the database.
     *
     * @param  AfterSchoolClub $afterschoolclub
     */
    public function store(Site $site, AfterSchoolClub $afterschoolclub)
    {
        $afterschoolclub->favourite($afterschoolclub);
    }

    /**
     * Delete the favorite.
     *
     * @param AfterSchoolClub $afterschoolclub
     */
    public function destroy(Site $site, AfterSchoolClub $afterschoolclub)
    {
        $afterschoolclub->unfavourite($afterschoolclub);
    }
}
