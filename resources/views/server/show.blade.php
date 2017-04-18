@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="page-header"><h1>{{ $server->name }} <span class="badge">PVP</span></h1></div>
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title">{{ $server->platform }}</h3>
        </div>

        <div class="panel-body">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a></li>
              <li role="presentation"><a href="#settings" aria-controls="rates" role="tab" data-toggle="tab">Settings</a></li>
              <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments</a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="info">
                <h4>Description</h4>
                <p>{{ $server->description }}</p>
                <br>
                <h4>Rules</h4>
                <p>Example rules can be included here.</p>
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
              </div>
          </div>
      </div>
      </div>
    </div>
  </div>
</div>
@endsection