<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Site;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        // $userActivity = Auth::user()->activity()->latest()->with('subject', 'subject.subject')->get();
        $userActivity = Auth::user()->activity()->latest()->with('subject')->take(15)->get();

        $events = Auth::user()->favourites()
                      ->where('subject_type', 'App\Event')
                      ->latest()
                      ->with('subject')
                      ->get()
                      ->groupBy(function ($favourites) {
                            return $favourites->created_at->format('F Y');
                      });

        return view('user.events', compact('events', 'userActivity'));
    }
}
