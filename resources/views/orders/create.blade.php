<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Create Order</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <div class="navbar-nav">
      <a class="nav-link" href="{{ route('concessions.index') }}">Concessions</a>
      <a class="nav-link active" href="{{ route('orders.index') }}">Orders</a>
      <a class="nav-link" href="{{ route('kitchen.index') }}">Kitchen</a>
    </div>
  </div>
</nav>
<main class="container py-4">
  <h3>Create Order</h3>

  <form method="post" action="{{ route('orders.store') }}" class="mt-3">
    @csrf
    <div class="mb-3">
      <label class="form-label">Select Concessions (multi-select)</label>
      <select name="concessions[]" class="form-select" multiple size="10" required>
        @foreach($concessions as $c)
          <option value="{{ $c->id }}">{{ $c->name }} — Rs {{ number_format($c->price,2) }}</option>
        @endforeach
      </select>
      @error('concessions')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Send to Kitchen Time</label>
      <input type="datetime-local" name="send_to_kitchen_at" class="form-control" required>
      @error('send_to_kitchen_at')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <button class="btn btn-primary">Save Order</button>
    <a class="btn btn-outline-secondary" href="{{ route('orders.index') }}">Cancel</a>
  </form>
</main>
</body>
</html>
