<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between w-100" id="mainNav">
      <!-- Left links -->
      <div class="navbar-nav">
        <a class="nav-link {{ request()->routeIs('concessions.*') ? 'active' : '' }}"
           href="{{ route('concessions.index') }}">Concessions</a>
        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
           href="{{ route('orders.index') }}">Orders</a>
        <a class="nav-link {{ request()->routeIs('kitchen.*') ? 'active' : '' }}"
           href="{{ route('kitchen.index') }}">Kitchen</a>
      </div>

      <!-- Right side (auth) -->
      <div class="navbar-nav align-items-center">
        @auth
          <span class="navbar-text me-2">
            {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
          </span>
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
