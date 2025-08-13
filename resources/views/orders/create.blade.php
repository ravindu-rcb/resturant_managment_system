<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Create Order</title>
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
    
    .section-header {
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
      height: 180px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    
    .product-card:hover img {
      transform: scale(1.05);
    }
    
    .product-card .card-body {
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
    }
    
    .product-card .title {
      font-weight: 600;
      font-size: 1.1rem;
      line-height: 1.3;
      min-height: 2.8em;
      color: #2c3e50;
      margin-bottom: 1rem;
    }
    
    .price-badge {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 0.95rem;
    }
    
    .btn-add {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(255, 225, 0, 0.4);
    }
    
    .btn-add:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(255, 225, 0, 0.6);
      color: #333;
    }
    
    .btn-view {
      background: linear-gradient(135deg, var(--accent-cream) 0%, var(--primary-yellow) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(235, 227, 137, 0.4);
      margin-top: auto;
    }
    
    .btn-view:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(235, 227, 137, 0.6);
      color: #333;
    }
    
    .order-form-card {
      background: white;
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      position: sticky;
      top: 2rem;
      transition: all 0.3s ease;
    }
    
    .order-form-card:hover {
      box-shadow: 0 6px 25px rgba(0,0,0,0.15);
    }
    
    .order-form-header {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      padding: 1.5rem;
      border-radius: 1rem 1rem 0 0;
      border: none;
    }
    
    .order-form-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 0;
    }
    
    .order-form-body {
      padding: 1.5rem;
    }
    
    .cart-item {
      background: #f8f9fa;
      border-radius: 0.75rem;
      padding: 1rem;
      margin-bottom: 1rem;
      border: 1px solid #e9ecef;
      transition: all 0.3s ease;
    }
    
    .cart-item:hover {
      background: #e9ecef;
      transform: translateX(5px);
    }
    
    .cart-item-name {
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 0.25rem;
    }
    
    .cart-item-price {
      color: #6c757d;
      font-size: 0.9rem;
    }
    
    .cart-item-total {
      font-weight: 600;
      color: var(--primary-orange);
      font-size: 1.1rem;
    }
    
    .qty-controls {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .qty-btn {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: 2px solid var(--primary-orange);
      background: white;
      color: var(--primary-orange);
      font-weight: 600;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .qty-btn:hover {
      background: var(--primary-orange);
      color: white;
      transform: scale(1.1);
    }
    
    .qty-display {
      min-width: 40px;
      text-align: center;
      font-weight: 600;
      color: #2c3e50;
    }
    
    .datetime-input {
      border: 2px solid #e9ecef;
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
    }
    
    .datetime-input:focus {
      border-color: var(--primary-orange);
      box-shadow: 0 0 0 0.2rem rgba(255, 155, 0, 0.25);
    }
    
    .total-section {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border-radius: 0.75rem;
      padding: 1.5rem;
      margin: 1.5rem 0;
      text-align: center;
      color: #333;
    }
    
    .total-label {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .total-amount {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary-orange);
    }
    
    .btn-clear {
      background: #6c757d;
      border: none;
      color: white;
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(108, 117, 125, 0.4);
    }
    
    .btn-clear:hover {
      background: #5a6268;
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(108, 117, 125, 0.6);
      color: white;
    }
    
    .btn-place-order {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      border: none;
      color: white;
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 155, 0, 0.4);
    }
    
    .btn-place-order:hover:not(:disabled) {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(255, 155, 0, 0.6);
      color: white;
    }
    
    .btn-place-order:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }
    
    .empty-cart {
      text-align: center;
      padding: 2rem;
      color: #6c757d;
    }
    
    .empty-cart i {
      font-size: 3rem;
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
    
    .form-label {
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 0.5rem;
    }
  </style>
</head>
<body>

<!-- Shared navbar component -->
<x-nav />

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <h1 class="page-title">Create Order</h1>
    <p class="page-subtitle">Select items and place your order</p>
  </div>
</div>

<main class="container">
  <div class="row g-4">
    <!-- LEFT: Products Section -->
    <div class="col-lg-8">
      <div class="section-header">
        <div class="row align-items-center">
          <div class="col-md-6 mb-3 mb-md-0">
            <h4 class="mb-0">
              <i class="fas fa-shopping-cart me-2"></i>Select Items
            </h4>
          </div>
          <div class="col-md-6">
            <div class="search-container">
              <i class="fas fa-search"></i>
              <input id="searchBox" type="text" class="form-control search-input" placeholder="Search items...">
            </div>
          </div>
        </div>
      </div>

      <div id="productGrid" class="row g-4">
        @foreach($concessions as $c)
          <div class="col-6 col-md-4 col-xl-3 product-col"
               data-name="{{ strtolower($c->name) }}">
            <div class="card product-card">
              <img src="{{ asset('storage/'.$c->image_path) }}" alt="{{ $c->name }}">
              <div class="card-body">
                <div class="title">{{ $c->name }}</div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="price-badge">Rs {{ number_format($c->price,2) }}</span>
                  <button class="btn btn-add"
                          onclick="addToCart({{ $c->id }}, '{{ addslashes($c->name) }}', {{ (float)$c->price }})">
                    <i class="fas fa-plus me-1"></i>Add
                  </button>
                </div>
                <button class="btn btn-view"
                        onclick="openViewModal('{{ addslashes($c->name) }}',
                                               '{{ addslashes($c->description ?? 'No description') }}',
                                               '{{ asset('storage/'.$c->image_path) }}',
                                               {{ (float)$c->price }})">
                  <i class="fas fa-eye me-1"></i>View
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- RIGHT: Order Form -->
    <div class="col-lg-4">
      <form id="orderForm" method="post" action="{{ route('orders.store') }}" onsubmit="return prepareSubmit()">
        @csrf
        <div class="card order-form-card">
          <div class="order-form-header">
            <h5 class="order-form-title">
              <i class="fas fa-receipt me-2"></i>Order Summary
            </h5>
          </div>
          
          <div class="order-form-body">
            <div id="cartList"></div>

            <div class="mb-4">
              <label class="form-label">
                <i class="fas fa-clock me-2"></i>Send to Kitchen Time
              </label>
              <input type="datetime-local" class="form-control datetime-input" name="send_to_kitchen_at" required>
            </div>

            <div class="total-section">
              <div class="total-label">Total Amount</div>
              <div class="total-amount" id="grandTotal">Rs 0.00</div>
            </div>

            <div class="d-flex gap-3">
              <button type="button" class="btn btn-clear flex-fill" onclick="clearCart()">
                <i class="fas fa-trash me-2"></i>Clear
              </button>
              <button type="submit" id="placeBtn" class="btn btn-place-order flex-fill" disabled>
                <i class="fas fa-check me-2"></i>Place Order
              </button>
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
        <img id="vmImg" src="" class="img-fluid rounded mb-3" alt="" style="width: 100%; height: 250px; object-fit: cover;">
        <p id="vmDesc" class="mb-3 text-muted"></p>
        <span id="vmPrice" class="price-badge"></span>
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
    document.getElementById('vmDesc').textContent = desc || 'No description available';
    document.getElementById('vmImg').src = img;
    document.getElementById('vmImg').alt = name;
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
  
  function inc(id){ 
    if(cart.has(id)){ 
      cart.get(id).qty++; 
      renderCart(); 
    } 
  }
  
  function dec(id){
    if(!cart.has(id)) return;
    cart.get(id).qty--;
    if(cart.get(id).qty <= 0) cart.delete(id);
    renderCart();
  }
  
  function clearCart(){ 
    cart.clear(); 
    renderCart(); 
  }

  function renderCart(){
    const wrap = document.getElementById('cartList');
    wrap.innerHTML = '';
    let total = 0;

    if(cart.size === 0){
      wrap.innerHTML = `
        <div class="empty-cart">
          <i class="fas fa-shopping-basket"></i>
          <h6 class="mb-2">No items yet</h6>
          <p class="mb-0">Start adding items to your order</p>
        </div>
      `;
    } else {
      cart.forEach(it => {
        const line = it.qty * it.price;
        total += line;
        const row = document.createElement('div');
        row.className = 'cart-item';
        row.innerHTML = `
          <div class="row align-items-center">
            <div class="col-8">
              <div class="cart-item-name">${it.name}</div>
              <div class="cart-item-price">${fmt(it.price)} each</div>
            </div>
            <div class="col-4">
              <div class="qty-controls">
                <button type="button" class="qty-btn" onclick="dec(${it.id})">–</button>
                <span class="qty-display">${it.qty}</span>
                <button type="button" class="qty-btn" onclick="inc(${it.id})">+</button>
              </div>
            </div>
          </div>
          <div class="text-end mt-2">
            <span class="cart-item-total">${fmt(line)}</span>
          </div>
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

  // Enhanced search with debouncing
  let searchTimeout;
  document.getElementById('searchBox').addEventListener('input', function(){
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      const q = this.value.trim().toLowerCase();
      document.querySelectorAll('#productGrid .product-col').forEach(col => {
        const name = col.getAttribute('data-name');
        col.style.display = (!q || name.includes(q)) ? '' : 'none';
      });
    }, 300);
  });

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

  renderCart();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
