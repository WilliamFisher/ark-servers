@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

          <div class="panel panel-default">
            <div class="panel-body">
              <div class="table-container">
  							<table class="table table-filter">
  								<tbody>
                    <tr>
                      <h3>{{ $title }}</h3>
                    </tr>
                    @foreach($servers as $server)
  									<tr data-status="green">
  										<td @if(!auth()->check()) class="hidden-xs" @endif>
                        @if($server->liked())
                        <a href="/servers/{{ $server->id }}/unlike" class="star-filled">
  												<i class="glyphicon glyphicon-star"></i>
  											</a>
                        @else
                        <a href="/servers/{{ $server->id }}/like" class="star">
  												<i class="glyphicon glyphicon-star"></i>
  											</a>
                        @endif
  										</td>
  										<td>
  											<div class="server">
  												<div class="server-body">
  													<h4 class="title">
  														<a class="{{ strtolower($server->platform) }}" href="{{ url('servers/' . $server->id) }}">{{ $server->name }} @if($server->rented)<span class="glyphicon glyphicon-flash" data-toggle="tooltip" data-placement="top" title="Rented Server" aria-hidden="true"></span>@endif</a>
  													</h4>
  													<p class="summary hidden-xs">{{ str_limit($server->description, $limit = 100, $end = '...') }}</p>
                            <div class="hidden-lg hidden-md hidden-sm">
                              <p class="server-rates">{{ $server->xp_rate }}x XP</p>
                              <p class="server-rates">{{ $server->gather_rate }}x Gather</p>
                              <p class="server-rates">{{ $server->tame_rate }}x Taming</p>
                            </div>
  												</div>
  											</div>
  										</td>
                      <td class="hidden-xs">
                        <div class="server">
                          <div class="server-body">
                            <p class="server-meta">{{ $server->xp_rate }}x XP</p>
                            <p class="server-meta">{{ $server->gather_rate }}x Gather</p>
                            <p class="server-meta">{{ $server->tame_rate }}x Taming</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="server">
                          <div class="server-info">
                            <h4 class="server-meta">{{ $server->map }}</h4>
                            <p class="server-meta">Wiped {{ $server->last_wipe->diffForHumans() }}</p>
                          <div>
                        </div>
                      </td>
  									</tr>
                    @endforeach
  								</tbody>
  							</table>
						   </div>
            </div>
          </div>
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

@section('scripts')
<script>
$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>
@endsection
