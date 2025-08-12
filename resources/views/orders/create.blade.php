@extends('layouts.app')
@section('content')
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
  </div>
  <div class="mb-3">
    <label class="form-label">Send to Kitchen Time</label>
    <input type="datetime-local" name="send_to_kitchen_at" class="form-control" required>
  </div>
  <button class="btn btn-primary">Save Order</button>
  <a class="btn btn-outline-secondary" href="{{ route('orders.index') }}">Cancel</a>
</form>
@endsection
