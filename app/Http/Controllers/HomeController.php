<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        //$this->middleware('auth',['except'=>['index']]);
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function locale(){
      $cookie = cookie()->forever('locale_forum', request('locale'));

      cookie()->queue($cookie);

      return ($return = request('return'))
      ? redirect(urldecode($return))->withCookie($cookie)
      : redirect(route('home'))->withCookie($cookie);
    }
}
