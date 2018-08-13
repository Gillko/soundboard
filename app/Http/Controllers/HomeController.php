<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Sound;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        //$sounds = Sound::all();

        //$sounds = Sound::all('sounds')->find($id)->sounds;

        return view('home')->with(['user' => Auth::user(), 'users' => $users]);//, 'sounds' => $sounds]);
    }
}