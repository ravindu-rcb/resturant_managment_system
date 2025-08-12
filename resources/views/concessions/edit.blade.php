@extends('layouts.app')
@section('content')
<h3>Edit Concession</h3>
<form method="post" enctype="multipart/form-data" action="{{ route('concessions.update',$concession) }}" class="mt-3">
  @csrf @method('PUT')
  <div class="mb-3"><label class="form-label">Name</label>
    <input name="name" class="form-control" required value="{{ old('name',$concession->name) }}">
  </div>
  <div class="mb-3"><label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description',$concession->description) }}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Image (leave empty to keep)</label>
    <input type="file" name="image" class="form-control">
    <div class="mt-2"><img src="{{ asset('storage/'.$concession->image_path) }}" width="80"></div>
  </div>
  <div class="mb-3"><label class="form-label">Price (Rs)</label>
    <input type="number" step="0.01" min="0" name="price" class="form-control" required value="{{ old('price',$concession->price) }}">
  </div>
  <button class="btn btn-primary">Update</button>
  <a class="btn btn-outline-secondary" href="{{ route('concessions.index') }}">Cancel</a>
</form>
@endsection
