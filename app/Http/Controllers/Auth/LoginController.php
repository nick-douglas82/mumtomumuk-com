<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
     protected function attemptLogin(Request $request)
     {
         return $this->guard()->attempt(
             $this->credentials($request), $request->has('remember')
         );
     }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($request->wantsJson()) {
            return response([
                'success' => true
            ], 200);
        };

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        $location = Session::pull('location');

        $this->guard()->logout();
        Session::flush();
        Session::regenerate();

        $parts = parse_url(url()->previous());

        $bits = array_filter(explode('/', $parts['path']));

        if (count($bits) <= 1) {
            return back();
        }

        if ($bits[2] === "users") {
            return redirect('/' . $bits[1]);
        } else {
            return back();
        }
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($site, $provider)
    {
        Session::put('returnUrl', url()->previous());
        Session::put('location', $site);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {

        // dd(url()->previous());

        $user     = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        $location = Session::pull('location');
        $returnUrl = Session::pull('returnUrl');

        Session::flush();
        Session::regenerate();

        return Redirect::to($returnUrl);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($providerUser, $provider)
    {
        $authUser = User::where('provider_id', $providerUser->id)->first();
        if ($authUser) return $authUser;

        $authUser = User::where('email', $providerUser->email)->first();

        if ($authUser) {
            $authUser->provider    = $provider;
            $authUser->provider_id = $providerUser->id;
            $authUser->avatar_path = 'avatars/' . $providerUser->id . '/avatar.jpg';
            $authUser->save();

            return $authUser;
        }


        $user = new User;

        $user->name        = $providerUser->name;
        $user->email       = $providerUser->email;
        $user->provider    = $provider;
        $user->provider_id = $providerUser->id;
        $user->avatar_path = 'avatars/' . $providerUser->id . '/avatar.jpg';

        $user->save();

        $contents = file_get_contents($providerUser->getAvatar());
        Storage::put('public/avatars/' . $providerUser->id . '/avatar.jpg', $contents);

        return $user;
    }
}
