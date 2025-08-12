@extends('layouts.app')
@section('content')
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
@endsection
