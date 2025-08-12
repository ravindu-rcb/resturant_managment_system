<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Edit Concession</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <div class="navbar-nav">
      <a class="nav-link" href="{{ route('concessions.index') }}">Concessions</a>
      <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
      <a class="nav-link" href="{{ route('kitchen.index') }}">Kitchen</a>
    </div>
  </div>
</nav>
<main class="container py-4">
  <h3>Edit Concession</h3>

  <form method="post" enctype="multipart/form-data" action="{{ route('concessions.update',$concession) }}" class="mt-3">
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input name="name" class="form-control" required value="{{ old('name',$concession->name) }}">
      @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control">{{ old('description',$concession->description) }}</textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Image (leave empty to keep)</label>
      <input type="file" name="image" class="form-control">
      <div class="mt-2"><img src="{{ asset('storage/'.$concession->image_path) }}" width="80"></div>
      @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Price (Rs)</label>
      <input type="number" step="0.01" min="0" name="price" class="form-control" required value="{{ old('price',$concession->price) }}">
      @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>
    <button class="btn btn-primary">Update</button>
    <a class="btn btn-outline-secondary" href="{{ route('concessions.index') }}">Cancel</a>
  </form>
</main>
</body>
</html>
