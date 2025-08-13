<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Create Order</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .product-card img{ width:100%; height:140px; object-fit:cover; border-top-left-radius:.5rem; border-top-right-radius:.5rem;}
    .product-card .card-body{ padding:.75rem }
    .product-card .title{ font-weight:600; font-size:.95rem; line-height:1.2; min-height:2.2em }
    .sticky-col{ position:sticky; top:16px }
    .qty-btn{ width:28px; height:28px; padding:0; line-height:1 }
    .cart-row{ display:flex; align-items:center; justify-content:space-between; gap:.5rem; padding:.35rem 0; border-bottom:1px dashed #e5e5e5 }
    .cart-row .name{ flex:1 }
  </style>
</head>
<body class="bg-light">

<!-- Shared navbar component -->
<x-nav />

<main class="container py-3">
  <div class="row g-3">
    <!-- LEFT: products -->
    <div class="col-lg-9">
      <div class="d-flex align-items-center mb-2">
        <h5 class="mb-0 me-3">Select Items</h5>
        <input id="searchBox" type="text" class="form-control" placeholder="Search items…" style="max-width:320px">
      </div>

      <div id="productGrid" class="row g-3">
        @foreach($concessions as $c)
          <div class="col-6 col-md-4 col-xl-3 product-col"
               data-name="{{ strtolower($c->name) }}">
            <div class="card shadow-sm product-card h-100">
              <img src="{{ asset('storage/'.$c->image_path) }}" alt="{{ $c->name }}">
              <div class="card-body d-flex flex-column">
                <div class="title mb-1">{{ $c->name }}</div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="badge bg-secondary">Rs {{ number_format($c->price,2) }}</span>
                  <button class="btn btn-sm btn-primary"
                          onclick="addToCart({{ $c->id }}, '{{ addslashes($c->name) }}', {{ (float)$c->price }})">
                    + Add
                  </button>
                </div>
                <button class="btn btn-sm btn-outline-secondary mt-auto"
                        onclick="openViewModal('{{ addslashes($c->name) }}',
                                               '{{ addslashes($c->description ?? 'No description') }}',
                                               '{{ asset('storage/'.$c->image_path) }}',
                                               {{ (float)$c->price }})">
                  View
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- RIGHT: cart -->
    <div class="col-lg-3">
      <form id="orderForm" method="post" action="{{ route('orders.store') }}" onsubmit="return prepareSubmit()">
        @csrf
        <div class="card shadow-sm sticky-col">
          <div class="card-body">
            <h5 class="card-title mb-3">Order</h5>

            <div id="cartList"></div>

            <div class="mt-3">
              <label class="form-label">Send to Kitchen Time</label>
              <input type="datetime-local" class="form-control" name="send_to_kitchen_at" required>
            </div>

            <hr class="my-3">
            <div class="d-flex justify-content-between fw-bold">
              <span>Total</span><span id="grandTotal">Rs 0.00</span>
            </div>

            <div class="d-flex gap-2 mt-3">
              <button type="button" class="btn btn-outline-danger flex-fill" onclick="clearCart()">Clear</button>
              <button type="submit" id="placeBtn" class="btn btn-primary flex-fill" disabled>Place Order</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
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
  // --- State ---
  const cart = new Map(); // id -> {id, name, price, qty}
  const fmt = n => 'Rs ' + Number(n).toFixed(2);

  function openViewModal(name, desc, img, price){
    document.getElementById('vmTitle').textContent = name;
    document.getElementById('vmDesc').textContent  = desc || '—';
    document.getElementById('vmImg').src           = img;
    document.getElementById('vmImg').alt           = name;
    document.getElementById('vmPrice').textContent = fmt(price);
    const m = new bootstrap.Modal(document.getElementById('viewModal'));
    m.show();
  }

  function addToCart(id, name, price){
    if(cart.has(id)){
      cart.get(id).qty += 1;
    } else {
      cart.set(id, {id, name, price: Number(price), qty: 1});
    }
    renderCart();
  }
  function inc(id){ if(cart.has(id)){ cart.get(id).qty++; renderCart(); } }
  function dec(id){
    if(!cart.has(id)) return;
    cart.get(id).qty--;
    if(cart.get(id).qty <= 0) cart.delete(id);
    renderCart();
  }
  function clearCart(){ cart.clear(); renderCart(); }

  function renderCart(){
    const wrap = document.getElementById('cartList');
    wrap.innerHTML = '';
    let total = 0;

    if(cart.size === 0){
      wrap.innerHTML = '<div class="text-muted small">No items yet.</div>';
    } else {
      cart.forEach(it => {
        const line = it.qty * it.price;
        total += line;
        const row = document.createElement('div');
        row.className = 'cart-row';
        row.innerHTML = `
          <div class="name">
            <div>${it.name}</div>
            <div class="small text-muted">${fmt(it.price)} each</div>
          </div>
          <div class="d-flex align-items-center" style="gap:.25rem">
            <button type="button" class="btn btn-outline-secondary btn-sm qty-btn" onclick="dec(${it.id})">–</button>
            <span class="px-1" style="min-width:22px; text-align:center">${it.qty}</span>
            <button type="button" class="btn btn-outline-secondary btn-sm qty-btn" onclick="inc(${it.id})">+</button>
          </div>
          <div class="fw-semibold" style="width:90px; text-align:right">${fmt(line)}</div>
        `;
        wrap.appendChild(row);
      });
    }

    document.getElementById('grandTotal').textContent = fmt(total);
    document.getElementById('placeBtn').disabled = (cart.size === 0);
  }

  // build hidden inputs before submit: items[id]=qty
  function prepareSubmit(){
    if(cart.size === 0) return false;
    document.querySelectorAll('#orderForm input[name^="items["]').forEach(el => el.remove());
    const form = document.getElementById('orderForm');
    cart.forEach(it => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = `items[${it.id}]`;
      input.value = String(it.qty);
      form.appendChild(input);
    });
    return true;
  }

  // live search
  document.getElementById('searchBox').addEventListener('input', function(){
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('#productGrid .product-col').forEach(col => {
      const name = col.getAttribute('data-name');
      col.style.display = (!q || name.includes(q)) ? '' : 'none';
    });
  });

  renderCart();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
