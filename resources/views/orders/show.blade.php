@extends('layouts.app')
@section('content')
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
@endsection
