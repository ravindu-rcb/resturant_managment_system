<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Order #{{ $order->id }}</title>
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
  <h3>Order #{{ $order->id }}</h3>
  <p><b>Send to Kitchen:</b> {{ $order->send_to_kitchen_at->format('Y-m-d H:i') }}</p>
  <p><b>Status:</b> {{ $order->status }}</p>

  <table class="table">
    <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
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
      <tr><th colspan="3" class="text-end">Total</th><th>Rs {{ number_format($order->total(),2) }}</th></tr>
    </tfoot>
  </table>
</main>
</body>
</html>
