<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Add Concession</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-orange: #FF9B00;
      --primary-yellow: #FFE100;
      --accent-gold: #FFC900;
      --accent-cream: #EBE389;
    }

    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-header {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      padding: 2rem 0;
      margin-bottom: 2rem;
      border-radius: 0 0 2rem 2rem;
      box-shadow: 0 4px 20px rgba(255, 155, 0, 0.3);
    }

    .page-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
      font-size: 1.1rem;
      opacity: 0.9;
      margin-bottom: 0;
    }

    .form-card {
      background: white;
      border: none;
      border-radius: 1.5rem;
      box-shadow: 0 8px 30px rgba(0,0,0,0.12);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .form-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }

    .form-header {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      padding: 2rem;
      text-align: center;
    }

    .form-header-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.9;
    }

    .form-title {
      font-size: 1.8rem;
      font-weight: 600;
      margin: 0;
    }

    .form-body {
      padding: 2.5rem;
    }

    .form-label {
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 0.75rem;
      font-size: 1rem;
    }

    .form-control {
      border: 2px solid #e9ecef;
      border-radius: 0.75rem;
      padding: 0.875rem 1rem;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    .form-control:focus {
      border-color: var(--primary-orange);
      box-shadow: 0 0 0 0.2rem rgba(255, 155, 0, 0.25);
      background: white;
      outline: none;
    }

    .form-control::placeholder {
      color: #adb5bd;
    }

    .file-input-wrapper {
      position: relative;
      overflow: hidden;
      display: inline-block;
      width: 100%;
    }

    .file-input-wrapper input[type=file] {
      position: absolute;
      left: -9999px;
    }

    .file-input-label {
      display: block;
      padding: 1rem;
      border: 2px dashed var(--primary-orange);
      border-radius: 0.75rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      background: rgba(255, 155, 0, 0.05);
      color: var(--primary-orange);
      font-weight: 600;
    }

    .file-input-label:hover {
      background: rgba(255, 155, 0, 0.1);
      border-color: var(--accent-gold);
      transform: translateY(-2px);
    }

    .file-input-label i {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      display: block;
    }

    .btn-save {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 225, 0, 0.4);
      font-size: 1rem;
    }

    .btn-save:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 225, 0, 0.6);
      color: #333;
    }

    .btn-cancel {
      background: #6c757d;
      border: none;
      color: white;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
      font-size: 1rem;
    }

    .btn-cancel:hover {
      background: #5a6268;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(108, 117, 125, 0.6);
      color: white;
    }

    .error-message {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.5rem;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .btn-group {
      gap: 1rem;
      margin-top: 2rem;
    }

    .preview-image {
      max-width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 0.75rem;
      margin-top: 1rem;
      border: 2px solid var(--primary-orange);
      display: none;
    }

    .form-control:invalid {
      border-color: #dc3545;
    }

    .form-control:valid {
      border-color: #198754;
    }

    @media (max-width: 768px) {
      .form-body {
        padding: 1.5rem;
      }

      .form-header {
        padding: 1.5rem;
      }

      .page-title {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

<!-- Shared navbar component -->
<x-nav />

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <h1 class="page-title">Add Concession</h1>
    <p class="page-subtitle">Create a new concession item for your menu</p>
  </div>
</div>

<main class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card form-card">
        <div class="form-header">
          <div class="form-header-icon">
            <i class="fas fa-plus-circle"></i>
          </div>
          <h2 class="form-title">New Concession Item</h2>
        </div>

        <div class="form-body">
          <form method="post" enctype="multipart/form-data" action="{{ route('concessions.store') }}" id="concessionForm">
            @csrf

            <div class="form-group">
              <label class="form-label">
                <i class="fas me-2"></i>Item Name
              </label>
              <input name="name" class="form-control" required value="{{ old('name') }}"
                     placeholder="Enter item name">
              @error('name')
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas me-2"></i>Description
              </label>
              <textarea name="description" class="form-control" rows="4"
                        placeholder="Describe your concession item">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas me-2"></i>Product Image
              </label>
              <div class="file-input-wrapper">
                <input type="file" name="image" id="imageInput" class="form-control" required accept="image/*">
                <label for="imageInput" class="file-input-label">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <div>Click to upload image</div>
                  <small>Supports: JPG, PNG, GIF, WEBP</small>
                </label>
              </div>
              <img id="imagePreview" class="preview-image" alt="Image preview">
              @error('image')
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas me-2"></i>Price (Rs)
              </label>
              <input type="number" step="0.01" min="0" name="price" class="form-control" required
                     value="{{ old('price') }}" placeholder="0.00">
              @error('price')
                <div class="error-message">
                  <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
              @enderror
            </div>

            <div class="d-flex btn-group">
              <button type="submit" class="btn btn-save flex-fill">
                <i class="fas fa-save me-2"></i>Save Concession
              </button>
              <a class="btn btn-cancel flex-fill" href="{{ route('concessions.index') }}">
                <i class="fas fa-times me-2"></i>Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  // Image preview functionality
  document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    } else {
      preview.style.display = 'none';
    }
  });

  // Form validation styling
  document.querySelectorAll('input[required], textarea[required]').forEach(input => {
    input.addEventListener('blur', function() {
      if (this.checkValidity()) {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
      } else {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
      }
    });
  });

  // Smooth animations
  document.addEventListener('DOMContentLoaded', function() {
    const formCard = document.querySelector('.form-card');
    formCard.style.opacity = '0';
    formCard.style.transform = 'translateY(30px)';

    setTimeout(() => {
      formCard.style.transition = 'all 0.8s ease';
      formCard.style.opacity = '1';
      formCard.style.transform = 'translateY(0)';
    }, 200);
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
