<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;

class ServerController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except('index','show');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = Server::all();

        return view('server.index', compact('servers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('server.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'name' => 'bail|required|string|unique:servers|max:16',
        'description' => 'required|string|max:300',
        'platform' => ['required', Rule::in(['Xbox', 'Playstation'])],
        'ispvp' => 'nullable|boolean',
        'ispve' => 'nullable|boolean',
        'map' => ['required', Rule::in(['The Island', 'The Center', 'Scorched Earth'])],
        'xprate' => 'required|numeric',
        'gatherrate' => 'required|numeric',
        'tamerate' => 'required|numeric',
        'breedingrate' => 'required|numeric',
        'lastwipe' => 'required|date',
      ]);

      $server = new Server;

      $server->user_id = Auth::user()->id;
      $server->name = $request->name;
      $server->description = $request->description;
      $server->platform = $request->platform;
      if($request->ispvp == null)
      {
        $server->is_pvp = false;
      }else{
        $server->is_pvp = true;
      }
      if($request->ispve == null)
      {
        $server->is_pve = false;
      }else {
        $server->is_pve = true;
      }
      $server->map = $request->map;
      $server->xp_rate = $request->xprate;
      $server->gather_rate = $request->gatherrate;
      $server->tame_rate = $request->tamerate;
      $server->breeding_rate = $request->breedingrate;
      $server->last_wipe = $request->lastwipe;

      $server->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
      return view('server.show', compact('server'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function edit(Server $server)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
    }
}
