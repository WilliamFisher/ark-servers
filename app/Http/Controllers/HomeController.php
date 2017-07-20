<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Server;
use Auth;

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
      $servers = User::find(Auth::user()->id)->servers;

      return view('home', compact('servers'));
    }

    public function favorited()
    {
      $user_id = Auth::user()->id;
      $servers = Server::whereLikedBy($user_id)->get();

      return view('home', compact('servers'));
    }
}
