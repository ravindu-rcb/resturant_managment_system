{{-- resources/views/components/nav.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}" style="font-size: 1.4rem;">{{ config('app.name') }}</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <!-- Centered main navigation -->
      <div class="navbar-nav mx-auto">
        <a class="nav-link fw-bold {{ request()->routeIs('concessions.*') ? 'active' : '' }}"
           href="{{ route('concessions.index') }}" style="font-size: 1.1rem; padding: 0.75rem 1.25rem;">Concessions</a>
        <a class="nav-link fw-bold {{ request()->routeIs('orders.*') ? 'active' : '' }}"
           href="{{ route('orders.index') }}" style="font-size: 1.1rem; padding: 0.75rem 1.25rem;">Orders</a>
        <a class="nav-link fw-bold {{ request()->routeIs('kitchen.*') ? 'active' : '' }}"
           href="{{ route('kitchen.index') }}" style="font-size: 1.1rem; padding: 0.75rem 1.25rem;">Kitchen</a>
      </div>

      <!-- Right auth block -->
      <div class="navbar-nav align-items-center">
        @auth
          <span class="navbar-text me-3 fw-semibold" style="font-size: 1rem;">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
          <form method="post" action="{{ route('logout') }}" class="d-inline">@csrf
            <button class="btn btn-sm btn-outline-light fw-bold" style="font-size: 0.95rem;">Logout</button>
          </form>
        @else
          <a class="nav-link fw-semibold" href="{{ route('login') }}" style="font-size: 1rem;">Login</a>
          <a class="nav-link fw-semibold" href="{{ route('register') }}" style="font-size: 1rem;">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
