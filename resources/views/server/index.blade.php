@extends('layouts.app')

@section('title', 'View Servers')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

          <div class="page-header"><h3>View Servers</h3></div>

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
                <p style="height:50px;">{{ str_limit($server->description, $limit = 100, $end = '...') }}</p><hr>
                <p>{{ $server->map }}</p><hr>
                <p>{{ $server->xp_rate }}x XP Rate</p><hr>
                <p>{{ $server->gather_rate }}x Gather Rate</p><hr>
                <p>{{ $server->tame_rate }}x Tame Rate</p><hr>
                @if($server->averageRating)
                <star-rating :inline="true" :show-rating="false" :read-only="true" :star-size="20" :rating="{{ $server->averageRating }}"></star-rating>
                @else
                <star-rating :inline="true" :show-rating="false" :read-only="true" :star-size="20" :rating="0"></star-rating>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
    </div>

    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        @if(app('request')->input('platform'))
        {{ $servers->appends(['platform' => $_GET['platform']])->links() }}
        @else
        {{ $servers->links() }}
        @endif
      </div>
    </div>
</div>
@endsection
