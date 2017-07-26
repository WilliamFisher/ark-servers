@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

          <div class="page-header"><h3>Created Servers</h3></div>
          @foreach($servers as $server)
          <div class="col-md-4">
            <div class="panel @if($server->platform == 'Xbox') panel-success @endif @if($server->platform == 'Playstation') panel-primary @endif">
              <div class="panel-heading">
                <div class="pull-right">@if($server->is_pvp)<span class="badge">PVP</span>@endif @if($server->is_pve)<span class="badge">PVE</span>@endif</div>
                <h3 class="panel-title">
                  <a href="{{ url('servers/' . $server->id) }}">{{ $server->name }}</a>
                </h3>
              </div>
              <div class="panel-body text-center">
                <p style="height:50px;">{{ str_limit($server->description, $limit = 80, $end = '...') }}</p><hr>
                <p>{{ $server->map }}</p><hr>
                <p>{{ $server->xp_rate }}x XP Rate</p><hr>
                <p>{{ $server->gather_rate }}x Gather Rate</p><hr>
                <p>{{ $server->tame_rate }}x Tame Rate</p>
              </div>
            </div>
          </div>
          @endforeach

          @if($servers->isEmpty())
            <div class="well">
              <p>You have not created any servers.</p>
              <a class="btn btn-default btn-sm" href="{{ route('servers.create') }}">Create Server</a>
            </div>
          @endif
        </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="page-header"><h3>Favorite Servers</h3></div>

        @foreach($favorites as $favorite)
        <div class="col-md-4">
          <div class="panel @if($favorite->platform == 'Xbox') panel-success @endif @if($favorite->platform == 'Playstation') panel-primary @endif">
            <div class="panel-heading">
              <div class="pull-right">@if($favorite->is_pvp)<span class="badge">PVP</span>@endif @if($favorite->is_pve)<span class="badge">PVE</span>@endif</div>
              <h3 class="panel-title">
                <a href="{{ url('servers/' . $favorite->id) }}">{{ $favorite->name }}</a>
              </h3>
            </div>
            <div class="panel-body text-center">
              <p style="height:50px;">{{ str_limit($favorite->description, $limit = 80, $end = '...') }}</p><hr>
              <p>{{ $favorite->map }}</p><hr>
              <p>{{ $favorite->xp_rate }}x XP Rate</p><hr>
              <p>{{ $favorite->gather_rate }}x Gather Rate</p><hr>
              <p>{{ $favorite->tame_rate }}x Tame Rate</p>
            </div>
          </div>
        </div>
        @endforeach

        @if($favorites->isEmpty())
          <div class="well">
            <p>You have not favorited any servers. Click the plus button on a server to add it to your favorites.</p>
          </div>
        @endif
    </div>
</div>
@endsection
