@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Edit Server</div>
        <div class="panel-body">
          @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <form class="form-horizontal" role="form" method="POST" action="{{ route('servers.store') }}">
            {{ csrf_field() }}
            <div class="form-group">

              <label for="name" class="col-md-4 control-label">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" placeholder="Gamertag or PSN name" name="name" value="{{ $server->name }}" maxlength="16" required autofocus>
              </div>
            </div>

            <div class="form-group">

              <label for="description" class="col-md-4 control-label">Description</label>

              <div class="col-md-6">
                <textarea class="form-control" name="description" id="description" rows="3" maxlength="500">{{ $server->description }}</textarea>
              </div>

            </div>

            <div class="form-group">

              <label for="platform" class="col-md-4 control-label">Platform</label>

              <div class="col-md-6">
                <select id="platform" class="form-control" name="platform" value="{{ $server->platform }}">
                  <option>Xbox</option>
                  <option>Playstation</option>
                </select>
              </div>
            </div>

            <div class="form-group">

              <label for="type" class="col-md-4 control-label">Type</label>

              <div class="col-md-6">
                <label class="checkbox-inline">
                  <input type="checkbox" id="ispvp" name="ispvp" value="1"> PvP
                </label>
                <label class="checkbox-inline">
                  <input type="checkbox" id="ispve" name="ispve" value="1"> PvE
                </label>
              </div>
            </div>

            <div class="form-group">

              <label for="map" class="col-md-4 control-label">Map</label>

              <div class="col-md-6">
                <select id="map" class="form-control" name="map" value="{{ $server->map }}">
                  <option>The Island</option>
                  <option>The Center</option>
                  <option>Scorched Earth</option>
                </select>
              </div>

            </div>

            <div class="form-group">

              <label for="xprate" class="col-md-4 control-label">XP Rate</label>

              <div class="col-md-6">
                <input id="xprate" type="number" step="0.01" class="form-control" name="xprate" value="{{ $server->xp_rate }}" required>
              </div>
            </div>

            <div class="form-group">

              <label for="gatherrate" class="col-md-4 control-label">Gather Rate</label>

              <div class="col-md-6">
                <input id="gatherrate" type="number" step="0.01" class="form-control" name="gatherrate" value="{{ $server->gather_rate }}" required>
              </div>
            </div>

            <div class="form-group">

              <label for="tamerate" class="col-md-4 control-label">Tame Rate</label>

              <div class="col-md-6">
                <input id="tamerate" type="number" step="0.01" class="form-control" name="tamerate" value="{{ $server->tame_rate }}" required>
              </div>
            </div>

            <div class="form-group">

              <label for="breedingrate" class="col-md-4 control-label">Breeding Rate</label>

              <div class="col-md-6">
                <input id="breedingrate" type="number" step="0.01" class="form-control" name="breedingrate" value="{{ $server->breeding_rate }}" required>
              </div>
            </div>

            <div class="form-group">

              <label for="lastwipe" class="col-md-4 control-label">Last Wipe</label>

              <div class="col-md-6">
                <input id="lastwipe" type="text" class="form-control" name="lastwipe" value="{{ $server->last_wipe }}" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-block btn-primary">
                  Update
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
