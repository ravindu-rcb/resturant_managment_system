<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Concessions</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .product-card img{ width:100%; height:160px; object-fit:cover; border-top-left-radius:.5rem; border-top-right-radius:.5rem; }
    .product-card .title{ font-weight:600; font-size:.98rem; line-height:1.2; min-height:2.4em; }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>

    <div class="navbar-nav">
      <a class="nav-link active" href="{{ route('concessions.index') }}">Concessions</a>
      <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
      <a class="nav-link" href="{{ route('kitchen.index') }}">Kitchen</a>
    </div>

    <div class="navbar-nav ms-auto align-items-center">
      @auth
        <span class="navbar-text me-2">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
        <form method="post" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button class="btn btn-sm btn-outline-light">Logout</button>
        </form>
      @else
        <a class="nav-link" href="{{ route('login') }}">Login</a>
        <a class="nav-link" href="{{ route('register') }}">Register</a>
      @endauth
    </div>
  </div>
</nav>

<main class="container py-4">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">Concessions</h3>
    <div class="d-flex align-items-center" style="gap:.5rem;">
      <input id="searchBox" type="text" class="form-control" placeholder="Search concessions…" style="max-width:260px">
      <a href="{{ route('concessions.create') }}" class="btn btn-primary">Add Concession</a>
    </div>
  </div>

  @if($concessions->count())
    <div id="cardGrid" class="row g-3">
      @foreach($concessions as $c)
        <div class="col-6 col-md-4 col-lg-3" data-name="{{ strtolower($c->name) }}">
          <div class="card h-100 shadow-sm product-card">
            <img src="{{ asset('storage/'.$c->image_path) }}" alt="{{ $c->name }}">
            <div class="card-body d-flex flex-column">
              <div class="title mb-1">{{ $c->name }}</div>
              <div class="mb-2">
                <span class="badge bg-secondary">Rs {{ number_format($c->price,2) }}</span>
              </div>

              <div class="mt-auto d-flex flex-wrap gap-2">
                <a href="{{ route('concessions.edit',$c) }}" class="btn btn-sm btn-secondary">Edit</a>

                <button type="button" class="btn btn-sm btn-outline-info"
                        onclick="openViewModal('{{ addslashes($c->name) }}',
                                               '{{ addslashes($c->description ?? 'No description') }}',
                                               '{{ asset('storage/'.$c->image_path) }}',
                                               {{ (float)$c->price }})">
                  View
                </button>

                <form action="{{ route('concessions.destroy',$c) }}" method="post" onsubmit="return confirm('Delete this item?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-3">
      {{ $concessions->links() }}
    </div>
  @else
    <div class="text-center text-muted py-5">No concessions yet.</div>
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
        <img id="vmImg" src="" class="img-fluid rounded mb-3" alt="">
        <p id="vmDesc" class="mb-2"></p>
        <span id="vmPrice" class="badge bg-secondary"></span>
      </div>
    </div>
  </div>
</div>

<script>
  // quick search
  document.getElementById('searchBox').addEventListener('input', function(){
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('#cardGrid > [data-name]').forEach(col => {
      const name = col.getAttribute('data-name');
      col.style.display = (!q || name.includes(q)) ? '' : 'none';
    });
  });

  // view modal
  function openViewModal(name, desc, img, price){
    document.getElementById('vmTitle').textContent = name;
    document.getElementById('vmDesc').textContent  = desc || '—';
    document.getElementById('vmImg').src           = img;
    document.getElementById('vmImg').alt           = name;
    document.getElementById('vmPrice').textContent = 'Rs ' + Number(price).toFixed(2);
    const m = new bootstrap.Modal(document.getElementById('viewModal'));
    m.show();
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
