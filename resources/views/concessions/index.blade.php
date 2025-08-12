<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Concessions</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>

    <!-- left links -->
    <div class="navbar-nav">
      <a class="nav-link active" href="{{ route('concessions.index') }}">Concessions</a>
      <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
      <a class="nav-link" href="{{ route('kitchen.index') }}">Kitchen</a>
    </div>

    <!-- right side auth block -->
    <div class="navbar-nav ms-auto align-items-center">
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
</nav>

<main class="container py-4">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Concessions</h3>
    <a href="{{ route('concessions.create') }}" class="btn btn-primary">Add Concession</a>
  </div>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Name</th>
        <th class="text-end">Price</th>
        <th class="text-end">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($concessions as $c)
        <tr>
          <td>{{ $c->id }}</td>
          <td>
            @if($c->image_path)
              <img src="{{ asset('storage/'.$c->image_path) }}" alt="{{ $c->name }}" width="60" height="60" style="object-fit:cover;">
            @endif
          </td>
          <td>{{ $c->name }}</td>
          <td class="text-end">Rs {{ number_format($c->price,2) }}</td>
          <td class="text-end">
            <a href="{{ route('concessions.edit',$c) }}" class="btn btn-sm btn-secondary">Edit</a>
            <form action="{{ route('concessions.destroy',$c) }}" method="post" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center text-muted">No concessions yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $concessions->links() }}
</main>

</body>
</html>
