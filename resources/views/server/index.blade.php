@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">All Servers</div>

                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Name</th>
                      <th>Map</th>
                      <th>Platform</th>
                    </tr>
                    <tr>
                      @foreach($servers as $server)
                      <td>{{ $server->name }}</td>
                      <td>{{ $server->map }}</td>
                      <td>{{ $server->platform }}</td>
                      @endforeach
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
