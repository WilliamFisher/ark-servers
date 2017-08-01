<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ark Servers is the number one place to find servers for the Xbox and Playstation. Find Xbox One and PS4 Ark servers with ease.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ark Servers - Xbox Servers - Playstation Servers</title>

    @include('shared.analytics')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body style="margin-bottom:0px;">
  <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Ark Servers</a>
      </div>
      <div class="collapse navbar-collapse navbar-right" id="app-navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          @if (Auth::guest())
              <li><a href="{{ url('/servers') }}">All Servers</a></li>
              <li><a href="{{ route('login') }}">Login</a></li>
              <li><a href="{{ route('register') }}">Register</a></li>
          @else
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu" role="menu">
                      <li><a href="{{ url('/servers') }}">All Servers</a></li>
                      <li><a href="{{ url('servers/create') }}">Add Server</a></li>
                      <li>
                          <a href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                              Logout
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                          </form>
                      </li>
                  </ul>
              </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>

  <header class="intro">
    <div class="intro-body" id="app">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1 class="brand-heading">Ark Servers</h1>
            <p>
              <a href="{{ url('/servers') }}" class="btn btn-default btn-lg">All Servers</a>
              <a href="{{ url('/servers/xbox') }}" class="btn btn-success btn-lg">Xbox Servers</a>
              <a href="{{ url('/servers/playstation') }}" class="btn btn-primary btn-lg">Playstation Servers</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
