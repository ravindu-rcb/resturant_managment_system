<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Add Concession</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Shared navbar component -->
<x-nav />

<main class="container py-4">
  <!-- BIG title outside the card -->
  <h1 class="display-5 text-center mb-4">Add Concession</h1>

  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow border-0">
        <div class="card-body p-4">
          <form method="post" enctype="multipart/form-data" action="{{ route('concessions.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input name="name" class="form-control" required value="{{ old('name') }}">
              @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Image</label>
              <input type="file" name="image" class="form-control" required>
              @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Price (Rs)</label>
              <input type="number" step="0.01" min="0" name="price" class="form-control" required value="{{ old('price') }}">
              @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary">Save</button>
              <a class="btn btn-outline-secondary" href="{{ route('concessions.index') }}">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
{{-- Needed for mobile navbar toggler --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
