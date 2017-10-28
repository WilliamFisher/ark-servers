<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use DB;
use willvincent\Rateable\Rating;

class ServerController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except('index', 'xbox', 'playstation', 'show', 'search');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $servers = Server::orderBy('average_rating', 'desc')->paginate(9);
      $title = "All Servers";

      return view('server.index', compact('servers', 'title'));
    }

    public function xbox()
    {
      $servers = Server::ofPlatform('xbox')->orderBy('average_rating', 'desc')->paginate(9);
      $title = "Xbox Servers";

      return view('server.index', compact('servers', 'title'));
    }

    public function playstation()
    {
      $servers = Server::ofPlatform('playstation')->orderBy('average_rating', 'desc')->paginate(9);
      $title = "Playstation Servers";

      return view('server.index', compact('servers', 'title'));
    }

    public function claim(Request $request, Server $server)
    {
      $key = env('XBOX_API_KEY');
      $client = new \GuzzleHttp\Client(['base_uri' => 'https://xboxapi.com/v2/']);
      $res = $client->request('GET', 'xuid/'.$server->name, [
        'headers' => [
          'X-AUTH' => $key
        ]
      ]);
      if($res->getStatusCode() == 200)
      {
        $xuid = $res->getBody();
      }
      else
      {
        return('Could not find gamertag');
      }

      $res = $client->request('GET', "{$xuid}/gamercard", [
        'headers' => [
          'X-AUTH' => $key
        ]
      ]);
      $json = json_decode($res->getBody(), true);
      $bio = $json['bio'];

      if(strpos($bio, 'arkservers:' .$server->id) !== false)
      {
        $server->user_id = Auth::user()->id;
        $server->claimed = true;
        $server->save();
        return ('Success');
      }
      else {
        return ('Could not find code');
      }
    }

    public function rateserver(Request $request, Server $server)
    {
      if($request->value > 5)
      {
        $request->value = 5;
      }

      if($server->userSumRating)
      {
        Rating::where('user_id', Auth::id())
                ->where('rateable_id', $server->id)
                ->update(['rating' => $request->value]);

        $server->average_rating = $server->averageRating();

        $server->save();

        return ('Thank you for updating your feedback!');
      }

      $rating = new Rating;
      $rating->rating = $request->value;
      $rating->user_id =  Auth::id();

      $server->ratings()->save($rating);

      $server->average_rating = $server->averageRating();
      $server->save();

      return ("Thank you for your feedback!");
    }

    public function search(Request $request)
    {
      $servers = Server::search($request->search)->paginate(9);

      return view('server.index', compact('servers'));
    }

    public function likeserver(Server $server)
    {
      $server->like();

      return back()->with('status', 'Added server to favorites.');
    }

    public function unlikeserver(Server $server)
    {
      $server->unlike();

      return back()->with('status', 'Removed server from favorites.');
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
        'rented' => ['required', Rule::in(['Home Console', 'Dedicated Hardware (Nitrado)'])],
        'rules' => 'nullable|string',
        'platform' => ['required', Rule::in(['Xbox', 'Playstation'])],
        'ispvp' => 'nullable|boolean',
        'ispve' => 'nullable|boolean',
        'map' => ['required', Rule::in(['The Island', 'The Center', 'Scorched Earth', 'Ragnarok'])],
        'xprate' => 'required|numeric',
        'gatherrate' => 'required|numeric',
        'tamerate' => 'required|numeric',
        'breedingrate' => 'required|numeric',
        'discordinvite' => 'nullable|url',
        'lastwipe' => 'required|date',
      ]);

      $server = new Server;

      $server->user_id = Auth::user()->id;
      $server->name = $request->name;
      $server->description = $request->description;
      if($request->rented == 'Dedicated Hardware (Nitrado)')
      {
        $server->rented = true;
      } else {
        $server->rented = false;
      }
      if($request->rules == null)
      {
        $server->rules = 'None';
      } else {
        $server->rules = $request->rules;
      }
      $server->platform = $request->platform;
      if($request->ispvp == null)
      {
        $server->is_pvp = false;
      } else {
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
      $server->discord_invite = $request->discordinvite;
      $server->last_wipe = $request->lastwipe;
      $server->claimed = true;

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
      $this->authorize('update', $server);

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
      $this->authorize('update', $server);

      $this->validate($request, [
        'name' => 'bail|required|max:16|string|unique:servers,name,'.$server->id,
        'description' => 'required|string|max:500',
        'rented' => ['required', Rule::in(['Home Console', 'Dedicated Hardware (Nitrado)'])],
        'rules' => 'nullable|string',
        'platform' => ['required', Rule::in(['Xbox', 'Playstation'])],
        'ispvp' => 'nullable|boolean',
        'ispve' => 'nullable|boolean',
        'map' => ['required', Rule::in(['The Island', 'The Center', 'Scorched Earth', 'Ragnarok'])],
        'xprate' => 'required|numeric',
        'gatherrate' => 'required|numeric',
        'tamerate' => 'required|numeric',
        'breedingrate' => 'required|numeric',
        'discordinvite' => 'nullable|url',
        'lastwipe' => 'required|date',
      ]);

      $server->name = $request->name;
      $server->description = $request->description;
      if($request->rented == 'Dedicated Hardware (Nitrado)')
      {
        $server->rented = true;
      } else {
        $server->rented = false;
      }
      if($request->rules == null)
      {
        $server->rules = 'None';
      }else {
        $server->rules = $request->rules;
      }
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
      $server->discord_invite = $request->discordinvite;
      $server->last_wipe = $request->lastwipe;
      $server->claimed = true;

      $server->save();

      return redirect()->action('ServerController@show', ['id' => $server->id])->with('status', 'Successfully updated server.');
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
