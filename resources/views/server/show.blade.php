@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="page-header"><h1>{{ $server->name }} @if($server->is_pvp)<span class="badge">PVP</span>@endif @if($server->is_pve)<span class="badge">PVE</span>@endif</h1>
      </div>
      @if (session('status'))
        <div class="alert alert-info">
          <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> {{ session('status') }}
        </div>
      @endif
      <div id="panel" class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">{{ $server->platform }}</h3>
        </div>

        <div class="panel-body">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#info" class="hidden-xs" aria-controls="info" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Info
                </a>
                <a href="#info" class="hidden-lg hidden-md hidden-sm" aria-controls="info" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                </a>
              </li>
              <li role="presentation">
                <a href="#settings" class="hidden-xs" aria-controls="rates" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-list" aria-hidden="true"></span> Settings
                </a>
                <a href="#settings" class="hidden-lg hidden-md hidden-sm" aria-controls="rates" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                </a>
              </li>
              <li role="presentation">
                <a href="#comments" class="hidden-xs" aria-controls="comments" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comments
                </a>
                <a href="#comments" class="hidden-lg hidden-md hidden-sm" aria-controls="comments" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                </a>
              </li>
              @if(!$server->liked())
              <li>
                <a class="hidden-xs" href="/servers/{{ $server->id }}/like">
                  <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add to Favorites
                </a>
                <a href="/servers/{{ $server->id }}/like" class="hidden-lg hidden-md hidden-sm">
                  <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                </a>
              </li>
              @else
              <li>
                <a class="hidden-xs" href="/servers/{{ $server->id }}/unlike">
                  <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> Remove Favorite
                </a>
                <a href="/servers/{{ $server->id }}/unlike" class="hidden-lg hidden-md hidden-sm">
                  <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
                </a>
              </li>
              @endif
              @if(!Auth::guest() && Auth::user()->id == $server->user_id)
              <li role="presentation">
                <a class="hidden-xs" href="#delete" aria-controls="delete" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                </a>
                <a href="#delete" class="hidden-lg hidden-md hidden-sm" aria-controls="delete" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
              </li>
              @endif
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="info">
                <h4>Description</h4>
                <p>{{ $server->description }}</p>
                <br>
                <h4>Rules</h4>
                <p>Example rules can be included here.</p>
                <br>
                <h4>Server last wiped {{ $server->last_wipe->diffForHumans() }}</h4>
                <form id="delete-form" action="{{ url('servers/' . $server->id) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                </form>
              </div>
              <div role="tabpanel" class="tab-pane" id="settings">
                <h4>Settings</h4>
                <hr>
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
                <div class="card">
                  <div class="card-block">
                    <form method="POST" action="/servers/{{ $server->id }}/comments">

                      {{ csrf_field() }}

                      <div class="form-group">
                        <textarea class="form-control" name="body" placeholder="Leave a comment." required></textarea>
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Comment</button>
                      </div>
                    </form>
                  </div>
                </div>
                <hr>
                <ul class="list-group">
                @foreach($server->comments as $comment)
                  <li class="list-group-item">
                    <strong>{{ $comment->user->name }}</strong>: {{ $comment->body }} - {{ $comment->created_at->diffForHumans() }}
                  </li>
                @endforeach
                </ul>
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
