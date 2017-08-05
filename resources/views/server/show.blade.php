@extends('layouts.app')

@section('title', {{ $server->name }})

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
                  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Info
                </a>
                <a href="#info" class="hidden-lg hidden-md hidden-sm" aria-controls="info" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                </a>
              </li>
              <li role="presentation">
                <a href="#share" class="hidden-xs" aria-controls="share" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share
                </a>
                <a href="#share" class="hidden-lg hidden-md hidden-sm" aria-controls="share" role="tab" data-toggle="tab">
                  <span class="glyphicon glyphicon-share" aria-hidden="true"></span>
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
              <li>
                <a class="hidden-xs" href="{{ route('servers.edit', $server->id) }}">
                  <span class="glyphicon glyphicon-edit"></span> Edit
                </a>
                <a href="{{ route('servers.edit', $server->id) }}" class="hidden-lg hidden-md hidden-sm">
                  <span class="glyphicon glyphicon-edit"></span>
                </a>
              </li>
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
                <div class="container">
                  <div class="row">
                    <div class="col-md-9">
                      <h4>Description</h4>
                      <p>{{ $server->description }}</p>
                      @if($server->averageRating)
                      <star-rating :show-rating="true" :star-size="20" :rating="{{ $server->averageRating }}" v-on:rating-selected="setRating"></star-rating>
                      @else
                      <star-rating :show-rating="true" :star-size="20" :rating="0" v-on:rating-selected="setRating"></star-rating>
                      @endif
                      <a href="" class="btn btn-primary btn-sm hidden-lg hidden-md hidden-sm">Join Discord</a>
                      <hr>
                    </div>
                    <div class="col-md-6">
                      <h4>Rates</h4>
                      <ul class="list-group">
                        <li class="list-group-item">{{ $server->map }}</li>
                        <li class="list-group-item">XP: {{ $server->xp_rate }}x</li>
                        <li class="list-group-item">Gather: {{ $server->gather_rate }}x</li>
                        <li class="list-group-item">Tame: {{ $server->tame_rate }}x</li>
                        <li class="list-group-item">Breeding: {{ $server->breeding_rate }}x</li>
                      </ul>
                      <h4>Rules</h4>
                      <div id="rules_section"></div>
                      <br>
                      <h4>Server last wiped {{ $server->last_wipe->diffForHumans() }}</h4>
                      <form id="delete-form" action="{{ url('servers/' . $server->id) }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          <input type="hidden" name="_method" value="DELETE">
                      </form>
                    </div>
                    <div class="col-md-3">
                      @if($server->discord_invite)
                      <h4 class="hidden-xs">Discord</h4>
                      <p><a class="btn btn-primary hidden-xs" href="{{ $server->discord_invite }}">Join Discord</a></p>
                      @elseif(!Auth::guest() && Auth::user()->id == $server->user_id)
                      <h4>Setup Discord</h4>
                      <p>This is only visable to you.</p>
                      <p>You have not setup Discord integration! Discord is a great place to house your server community.</p>
                      <p>Create an instant invite and set it to expire 'Never'. Then paste the link into the Discord invite field when you edit your server.</p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="share">
                <h4>Share</h4>
                <div class="well">
                  <div class="addthis_inline_share_toolbox"></div>
                </div>
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

<script>
function decodeHTML(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}
$(document).ready(function() {
  var rules = decodeHTML('{{ $server->rules }}');
  var array = rules.split(',');

  function makeUL(array) {
    var list = document.createElement('ul');

    list.className = 'list-group';

    for(var i=0; i < array.length; i++)
    {
      var item = document.createElement('li');

      item.className = 'list-group-item';

      item.appendChild(document.createTextNode(array[i]));

      list.appendChild(item);
    }

    return list;
  }

  $( "#rules_section" ).append(makeUL(array));
});
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-597f4311f55d7401"></script>
@endsection
