<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\AuthGetIP;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Ramsey\Uuid\Uuid;
use Str;

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
    protected $redirectTo = "/";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubRedirect(): RedirectResponse
    {
        $user = Socialite::driver('github')->user();

        $auth = User::firstOrCreate(
            [
                'github_id' => $user->id,
            ],
            [
                'id'          => Uuid::uuid4(),
                'name'        => $user->name ?? '',
                'description' => $user->user['bio'],
                'email'       => $user->email,
                'username'    => $user->nickname,
                'github_id'   => $user->id,
                'github_url'  => $user->user['html_url'],
                'password'    => Hash::make(Str::random(24)),
            ]
        );

        Auth::login($auth, true);

        return back();
    }
}
