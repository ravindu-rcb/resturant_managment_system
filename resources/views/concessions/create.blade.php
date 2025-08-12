@extends('layouts.app')
@section('content')
<h3>Add Concession</h3>
<form method="post" enctype="multipart/form-data" action="{{ route('concessions.store') }}" class="mt-3">
  @csrf
  <div class="mb-3"><label class="form-label">Name</label>
    <input name="name" class="form-control" required value="{{ old('name') }}">
  </div>
  <div class="mb-3"><label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
  </div>
  <div class="mb-3"><label class="form-label">Image</label>
    <input type="file" name="image" class="form-control" required>
  </div>
  <div class="mb-3"><label class="form-label">Price (Rs)</label>
    <input type="number" step="0.01" min="0" name="price" class="form-control" required value="{{ old('price') }}">
  </div>
  <button class="btn btn-primary">Save</button>
  <a class="btn btn-outline-secondary" href="{{ route('concessions.index') }}">Cancel</a>
</form>
@endsection
