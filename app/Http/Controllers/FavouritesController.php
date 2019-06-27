<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
