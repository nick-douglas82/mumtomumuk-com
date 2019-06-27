<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Site;


class PassportController extends Controller
{
    public $successStatus = 200;

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        $user = User::all();

        return response()->json(['success' => $user], $this->successStatus);
    }
}
