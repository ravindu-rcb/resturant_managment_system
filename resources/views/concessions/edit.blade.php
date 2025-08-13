<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Edit Concession</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<!-- Shared navbar component -->
<x-nav />

<main class="container py-4">
  <!-- BIG title outside the card -->
  <h1 class="display-5 text-center mb-4">Edit Concession</h1>

  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow border-0">
        <div class="card-body p-4">
          <form method="post" enctype="multipart/form-data" action="{{ route('concessions.update',$concession) }}">
            @csrf @method('PUT')

            <div class="mb-3">
              <label class="form-label">Name</label>
              <input name="name" class="form-control" required value="{{ old('name',$concession->name) }}">
              @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="3">{{ old('description',$concession->description) }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Image (leave empty to keep)</label>
              <input type="file" name="image" class="form-control">
              @if($concession->image_path)
                <div class="mt-2">
                  <img src="{{ asset('storage/'.$concession->image_path) }}" width="100" height="100" style="object-fit:cover;" class="rounded border">
                </div>
              @endif
              @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Price (Rs)</label>
              <input type="number" step="0.01" min="0" name="price" class="form-control" required value="{{ old('price',$concession->price) }}">
              @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary">Update</button>
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
