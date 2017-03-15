<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
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

        $this->middleware('guest', ['except' => 'logout']);
        parent::__construct();
    }

    public function redirectToProvider()
    {
        return \Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = \Socialite::driver('github')->user();

        $user = \App\User::firstOrCreate([
            'name'  => $user->getName(),
            'email' => $user->getEmail(),
            'password'=> $user->getName(),
        ]);

        auth()->login($user, true);

        return redirect(route('home'));
    }
}