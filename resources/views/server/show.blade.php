@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="page-header"><h1>{{ $server->name }} @if($server->is_pvp)<span class="badge">PVP</span>@endif @if($server->is_pve)<span class="badge">PVE</span>@endif</h1>
      </div>
      <div id="panel" class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">{{ $server->platform }}</h3>
        </div>

        <div class="panel-body">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a></li>
              <li role="presentation"><a href="#settings" aria-controls="rates" role="tab" data-toggle="tab">Settings</a></li>
              <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
              @if(!$server->liked())<li><a href="/servers/{{ $server->id }}/like">Add to Favorites</a></li> @else <li><a href="/servers/{{ $server->id }}/unlike">Remove Favorite</a></li>@endif
              @if(!Auth::guest() && Auth::user()->id == $server->user_id)<li role="presentation"><a href="#delete" aria-controls="delete" role="tab" data-toggle="tab">Delete</a></li>@endif
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="info">
                <h4>Description</h4>
                <p>{{ $server->description }}</p>
                <br>
                <h4>Rules</h4>
                <p>Example rules can be included here.</p>
                <br>
                <h4>Server last wiped {{ $server->last_wipe->diffInDays() }} day(s) ago</h4>
                <form id="delete-form" action="{{ url('servers/' . $server->id) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                </form>
              </div>
              <div role="tabpanel" class="tab-pane" id="settings">
                <h4>Settings</h4>
                <ul class="list-group">
                  <li class="list-group-item">{{ $server->map }}</li>
                  <li class="list-group-item">XP: {{ $server->xp_rate }}x</li>
                  <li class="list-group-item">Gather: {{ $server->gather_rate }}x</li>
                  <li class="list-group-item">Tame: {{ $server->tame_rate }}x</li>
                  <li class="list-group-item">Breeding: {{ $server->breeding_rate }}x</li>
                </ul>
              </div>
              <div role="tabpanel" class="tab-pane" id="comments">
                <h4>Comments</h4>
                <div class="well">Nothing to see here! This feature is coming soon.</div>
              </div>
              <div role="tabpanel" class="tab-pane" id="delete">
                <h4>Confirm Delete</h4>
                  <a class="btn btn-sm btn-danger" href="{{ url('servers/' . $server->id) }}" onclick="event.preventDefault();
                           document.getElementById('delete-form').submit();">Delete
                  </a>
              </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  if('{{ $server->platform }}' == 'Xbox') {
    $( "#panel" ).addClass( "panel-success" );
  } else {
    $( "#panel" ).addClass( "panel-primary" );
  }
});
</script>
@endsection
