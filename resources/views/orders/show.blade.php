<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Order #{{ $order->id }}</title>
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
      <a class="nav-link" href="{{ route('concessions.index') }}">Concessions</a>
      <a class="nav-link active" href="{{ route('orders.index') }}">Orders</a>
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
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h3 class="mb-0">Order #{{ $order->id }}</h3>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">Back to Orders</a>
  </div>

  <p class="mb-1">
    <b>Send to Kitchen:</b> {{ $order->send_to_kitchen_at->format('Y-m-d H:i') }}
  </p>
  <p>
    <b>Status:</b>
    @php $s = $order->status; @endphp
    <span class="badge {{ $s==='Pending' ? 'bg-warning' : ($s==='In-Progress' ? 'bg-info' : 'bg-success') }}">
      {{ $s }}
    </span>
  </p>

  <table class="table">
    <thead>
      <tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
    </thead>
    <tbody>
      @foreach($order->items as $it)
        <tr>
          <td>{{ $it->concession->name }}</td>
          <td>{{ $it->quantity }}</td>
          <td>Rs {{ number_format($it->price,2) }}</td>
          <td>Rs {{ number_format($it->price * $it->quantity,2) }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="text-end">Total</th>
        <th>Rs {{ number_format($order->total(),2) }}</th>
      </tr>
    </tfoot>
  </table>
</main>

</body>
</html>
