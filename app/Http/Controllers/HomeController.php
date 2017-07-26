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
      $user_id = Auth::user()->id;
      $favorites = Server::whereLikedBy($user_id)->get();
      $servers = User::find(Auth::user()->id)->servers;

      return view('dashboard.home', compact('servers', 'favorites'));
    }
}
