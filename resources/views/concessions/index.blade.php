<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Concessions</title>
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
    
    .controls-section {
      background: white;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      margin-bottom: 2rem;
    }
    
    .search-container {
      position: relative;
      max-width: 400px;
    }
    
    .search-container i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
      z-index: 10;
    }
    
    .search-input {
      padding-left: 45px;
      border: 2px solid #e9ecef;
      border-radius: 25px;
      transition: all 0.3s ease;
      height: 50px;
      font-size: 1rem;
    }
    
    .search-input:focus {
      border-color: var(--primary-orange);
      box-shadow: 0 0 0 0.2rem rgba(255, 155, 0, 0.25);
    }
    
    .btn-add {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 225, 0, 0.4);
    }
    
    .btn-add:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 225, 0, 0.6);
      color: #333;
    }
    
    .product-card {
      border: none;
      border-radius: 1rem;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      height: 100%;
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .product-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    
    .product-card:hover img {
      transform: scale(1.05);
    }
    
    .product-card .title {
      font-weight: 600;
      font-size: 1.1rem;
      line-height: 1.3;
      min-height: 2.8em;
      color: #2c3e50;
      margin-bottom: 0.75rem;
    }
    
    .price-badge {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 0.95rem;
    }
    
    .btn-edit {
      background: linear-gradient(135deg, var(--accent-cream) 0%, var(--primary-yellow) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(235, 227, 137, 0.4);
    }
    
    .btn-edit:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(235, 227, 137, 0.6);
      color: #333;
    }
    
    .btn-view {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(255, 225, 0, 0.4);
    }
    
    .btn-view:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(255, 225, 0, 0.6);
      color: #333;
    }
    
    .btn-delete {
      background: #dc3545;
      border: none;
      color: white;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(220, 53, 69, 0.4);
    }
    
    .btn-delete:hover {
      background: #c82333;
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.6);
      color: white;
    }
    
    .card-body {
      padding: 1.25rem;
    }
    
    .action-buttons {
      gap: 0.5rem;
      margin-top: auto;
    }
    
    .empty-state {
      background: white;
      padding: 3rem;
      border-radius: 1rem;
      text-align: center;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    
    .empty-state i {
      font-size: 4rem;
      color: var(--primary-orange);
      margin-bottom: 1rem;
    }
    
    .modal-content {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .modal-header {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      border-radius: 1rem 1rem 0 0;
      border: none;
    }
    
    .modal-title {
      font-weight: 600;
    }
    
    .btn-close {
      filter: invert(1);
    }
    
    .pagination .page-link {
      border: none;
      color: var(--primary-orange);
      border-radius: 0.5rem;
      margin: 0 0.2rem;
    }
    
    .pagination .page-item.active .page-link {
      background: var(--primary-orange);
      border-color: var(--primary-orange);
    }
    
    .pagination .page-link:hover {
      background: var(--accent-gold);
      color: white;
    }
  </style>
</head>
<body>

<!-- Shared navbar component -->
<x-nav />

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <h1 class="page-title">Concessions</h1>
    <p class="page-subtitle">Manage your concession items and products</p>
  </div>
</div>

<main class="container">
  @if(session('ok')) 
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i>
      {{ session('ok') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div> 
  @endif

  <!-- Controls Section -->
  <div class="controls-section">
    <div class="row align-items-center">
      <div class="col-md-6 mb-3 mb-md-0">
        <div class="search-container">
          <i class="fas fa-search"></i>
          <input id="searchBox" type="text" class="form-control search-input" placeholder="Search concessions...">
        </div>
      </div>
      <div class="col-md-6 text-md-end">
        <a href="{{ route('concessions.create') }}" class="btn btn-add">
          <i class="fas fa-plus me-2"></i>Add New Concession
        </a>
      </div>
    </div>
  </div>

  @if($concessions->count())
    <div id="cardGrid" class="row g-4">
      @foreach($concessions as $c)
        <div class="col-6 col-md-4 col-lg-3" data-name="{{ strtolower($c->name) }}">
          <div class="card product-card">
            <img src="{{ asset('storage/'.$c->image_path) }}" alt="{{ $c->name }}">
            <div class="card-body d-flex flex-column">
              <div class="title">{{ $c->name }}</div>
              <div class="mb-3">
                <span class="price-badge">Rs {{ number_format($c->price,2) }}</span>
              </div>

              <div class="action-buttons d-flex flex-wrap">
                <a href="{{ route('concessions.edit',$c) }}" class="btn btn-edit">
                  <i class="fas fa-edit me-1"></i>Edit
                </a>

                <button type="button" class="btn btn-view"
                        onclick="openViewModal('{{ addslashes($c->name) }}',
                                               '{{ addslashes($c->description ?? 'No description') }}',
                                               '{{ asset('storage/'.$c->image_path) }}',
                                               {{ (float)$c->price }})">
                  <i class="fas fa-eye me-1"></i>View
                </button>

                <form action="{{ route('concessions.destroy',$c) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this concession item?')" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-delete">
                    <i class="fas fa-trash me-1"></i>Delete
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
      {{ $concessions->links() }}
    </div>
  @else
    <div class="empty-state">
      <i class="fas fa-box-open"></i>
      <h4 class="text-muted mb-3">No Concessions Yet</h4>
      <p class="text-muted mb-4">Start building your concession menu by adding your first item.</p>
      <a href="{{ route('concessions.create') }}" class="btn btn-add">
        <i class="fas fa-plus me-2"></i>Add Your First Concession
      </a>
    </div>
  @endif
</main>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="vmTitle" class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="vmImg" src="" class="img-fluid rounded mb-3" alt="" style="width: 100%; height: 250px; object-fit: cover;">
        <p id="vmDesc" class="mb-3 text-muted"></p>
        <span id="vmPrice" class="price-badge"></span>
      </div>
    </div>
  </div>
</div>

<script>
  // Enhanced search with debouncing
  let searchTimeout;
  document.getElementById('searchBox').addEventListener('input', function(){
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      const q = this.value.trim().toLowerCase();
      document.querySelectorAll('#cardGrid > [data-name]').forEach(col => {
        const name = col.getAttribute('data-name');
        col.style.display = (!q || name.includes(q)) ? '' : 'none';
      });
    }, 300);
  });

  // Enhanced view modal
  function openViewModal(name, desc, img, price){
    document.getElementById('vmTitle').textContent = name;
    document.getElementById('vmDesc').textContent = desc || 'No description available';
    document.getElementById('vmImg').src = img;
    document.getElementById('vmImg').alt = name;
    document.getElementById('vmPrice').textContent = 'Rs ' + Number(price).toFixed(2);
    const m = new bootstrap.Modal(document.getElementById('viewModal'));
    m.show();
  }

  // Add smooth animations
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.product-card');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      setTimeout(() => {
        card.style.transition = 'all 0.6s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, index * 100);
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
