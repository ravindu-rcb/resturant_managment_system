<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', config('app.name'))</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  @stack('head')
  @stack('styles')
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between w-100" id="mainNav">
      <!-- Left nav -->
      <div class="navbar-nav">
        <a class="nav-link {{ request()->routeIs('concessions.*') ? 'active' : '' }}"
           href="{{ route('concessions.index') }}">Concessions</a>
        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
           href="{{ route('orders.index') }}">Orders</a>
        <a class="nav-link {{ request()->routeIs('kitchen.*') ? 'active' : '' }}"
           href="{{ route('kitchen.index') }}">Kitchen</a>
      </div>

      <!-- Right nav -->
      <div class="navbar-nav align-items-center">
        {{-- DEBUG (remove later): shows whether you're logged in --}}
        <span class="navbar-text me-3 small text-warning">
          {{ auth()->check() ? 'logged in' : 'guest' }}
        </span>

        @auth
          <span class="navbar-text me-2">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
          <form method="post" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-sm btn-outline-light">Logout</button>
          </form>
        @else
          <a class="nav-link" href="{{ route('login') }}">Login</a>
          <a class="nav-link" href="{{ route('register') }}">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>

<main class="container py-4">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @yield('content')
</main>

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
