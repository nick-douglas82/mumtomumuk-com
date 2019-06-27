<?php

namespace App\Http\Controllers\Directory;

use App\Directory;
use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;

class DirectoryFavouriteController extends Controller
{
    /**
     * Store a new favourite in the database.
     *
     * @param  Directory $directory
     */
    public function store(Site $site, Directory $directory)
    {
        $directory->favourite($directory);
    }

    /**
     * Delete the favourite.
     *
     * @param Diretory $directory
     */
    public function destroy(Site $site, Directory $directory)
    {
        $directory->unfavourite($directory);
    }
}
