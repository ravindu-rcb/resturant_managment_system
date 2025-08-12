<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Concessions</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <div class="navbar-nav">
      <a class="nav-link active" href="{{ route('concessions.index') }}">Concessions</a>
      <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
      <a class="nav-link" href="{{ route('kitchen.index') }}">Kitchen</a>
    </div>
  </div>
</nav>
<main class="container py-4">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Concessions</h3>
    <a href="{{ route('concessions.create') }}" class="btn btn-primary">Add Concession</a>
  </div>

  <table class="table table-striped">
    <thead><tr><th>#</th><th>Image</th><th>Name</th><th>Price</th><th></th></tr></thead>
    <tbody>
      @foreach($concessions as $c)
        <tr>
          <td>{{ $c->id }}</td>
          <td><img src="{{ asset('storage/'.$c->image_path) }}" alt="" width="60"></td>
          <td>{{ $c->name }}</td>
          <td>Rs {{ number_format($c->price,2) }}</td>
          <td class="text-end">
            <a href="{{ route('concessions.edit',$c) }}" class="btn btn-sm btn-secondary">Edit</a>
            <form action="{{ route('concessions.destroy',$c) }}" method="post" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $concessions->links() }}
</main>
</body>
</html>
