<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use DB;

class ServerController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except('index','show', 'search');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $servers = Server::all();

      if ($platform = request('platform'))
      {
        $servers = Server::ofPlatform($platform)->get();
      }

      return view('server.index', compact('servers'));
    }

    public function search(Request $request)
    {
      $servers = Server::search($request->search)->get();

      return view('server.index', compact('servers'));
    }

    public function likeserver($id)
    {
      $server = Server::find($id);
      $server->like();

      return back();
    }

    public function unlikeserver($id)
    {
      $server = Server::find($id);
      $server->unlike();

      return back();
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
        'description' => 'required|string|max:500',
        'platform' => ['required', Rule::in(['Xbox', 'Playstation'])],
        'ispvp' => 'nullable|boolean',
        'ispve' => 'nullable|boolean',
        'map' => ['required', Rule::in(['The Island', 'The Center', 'Scorched Earth', 'Ragnarok'])],
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

      return redirect()->action('ServerController@show', ['id' => $server->id]);
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
      return view('server.edit', compact('server'));
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
      $this->authorize('delete', $server);

      $server->delete();

      return redirect('servers');
    }
}
