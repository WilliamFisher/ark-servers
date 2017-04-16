@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">All Servers</div>

                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Map</th>
                      <th>Platform</th>
                      <th>PvP</th>
                      <th>PvE</th>
                      <th>XP Rate</th>
                      <th>Actions</th>
                    </tr>
                    <tr>
                      @foreach($servers as $server)
                      <td>{{ $server->name }}</td>
                      <td>{{ $server->description }}</td>
                      <td>{{ $server->map }}</td>
                      <td>{{ $server->platform }}</td>
                      <td>{{ $server->is_pvp }}</td>
                      <td>{{ $server->is_pve }}</td>
                      <td>{{ $server->xp_rate }}</td>
                      <td><a class="btn btn-sm btn-primary" href="{{ url('servers/' . $server->id) }}">View</a></td>
                      @endforeach
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
