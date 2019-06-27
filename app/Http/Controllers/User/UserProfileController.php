<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Site;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User\Profile;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $userActivity = Auth::user()->activity()->latest()->with('subject')->take(15)->get();

        return view('user.profile', compact('userActivity'));
    }

    public function update(Site $site, Request $request)
    {

        $validation = ['errors' => []];

        $profile    = new Profile($validation);

        $validation = $profile->updatePassword( $request->params['password'] );
        $validation = $profile->updateName( $request->params['name'] );
        $validation = $profile->updateEmail( $request->params['email'] );

        return response()->json($validation);

    }
}

