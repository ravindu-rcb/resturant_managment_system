<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Orders</title>
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

    .btn-create-order {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 225, 0, 0.4);
    }

    .btn-create-order:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 225, 0, 0.6);
      color: #333;
    }

    .orders-table {
      background: white;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      border: none;
    }

    .orders-table thead {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
    }

    .orders-table th {
      border: none;
      padding: 1.25rem 1rem;
      font-weight: 600;
      font-size: 1rem;
    }

    .orders-table tbody tr {
      transition: all 0.3s ease;
      border-bottom: 1px solid #f1f3f4;
    }

    .orders-table tbody tr:hover {
      background: #f8f9fa;
      transform: translateX(5px);
    }

    .orders-table td {
      padding: 1.25rem 1rem;
      border: none;
      vertical-align: middle;
    }

    .order-id {
      font-weight: 600;
      color: var(--primary-orange);
      font-size: 1.1rem;
    }

    .status-badge {
      padding: 8px 16px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .status-pending {
      background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
      color: #333;
    }

    .status-in-progress {
      background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
      color: white;
    }

    .status-completed {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      color: white;
    }

    .items-count {
      background: var(--accent-cream);
      color: #333;
      padding: 6px 12px;
      border-radius: 15px;
      font-weight: 600;
      font-size: 0.9rem;
    }

    .total-amount {
      font-weight: 700;
      color: var(--primary-orange);
      font-size: 1.1rem;
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
    }

    .btn-view:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(235, 227, 137, 0.6);
      color: #333;
    }

    .btn-send-now {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(255, 225, 0, 0.4);
    }

    .btn-send-now:hover {
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

    .action-buttons {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .pagination .page-link {
      border: none;
      color: var(--primary-orange);
      border-radius: 0.5rem;
      margin: 0 0.2rem;
      padding: 0.75rem 1rem;
      font-weight: 600;
    }

    .pagination .page-item.active .page-link {
      background: var(--primary-orange);
      border-color: var(--primary-orange);
      color: #fff;
    }

    .pagination .page-item.disabled .page-link {
      background: #e9ecef;
      color: #6c757d;
    }

    .pagination .page-link:hover {
      background: var(--accent-gold);
      color: white;
    }

    .alert-success {
      background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
      border: none;
      border-radius: 1rem;
      color: #155724;
      padding: 1rem 1.5rem;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08);
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

    @media (max-width: 768px) {
      .orders-table {
        font-size: 0.9rem;
      }

      .orders-table th,
      .orders-table td {
        padding: 0.75rem 0.5rem;
      }

      .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
      }

      .btn-view,
      .btn-send-now,
      .btn-delete {
        padding: 6px 16px;
        font-size: 0.85rem;
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
    <h1 class="page-title">Orders</h1>
    <p class="page-subtitle">Manage and track your restaurant orders</p>
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
        <h4 class="mb-0">
          <i class="fas fa-list me-2"></i>Order Management
        </h4>
      </div>
      <div class="col-md-6 text-md-end">
        <a href="{{ route('orders.create') }}" class="btn btn-create-order">
          <i class="fas fa-plus me-2"></i>Create New Order
        </a>
      </div>
    </div>
  </div>

  @if($orders->count())
    <div class="table-responsive">
      <table class="table orders-table">
        <thead>
          <tr>
            <th><i class="fas me-2"></i>Order ID</th>
            <th><i class="fas me-2"></i>Send to Kitchen</th>
            <th><i class="fas me-2"></i>Status</th>
            <th><i class="fas me-2"></i>Items</th>
            <th><i class="fas me-2"></i>Total</th>
            <th><i class="fas me-2"></i>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $o)
          <tr id="order-row-{{ $o->id }}" data-order-id="{{ $o->id }}">
            <td><span class="order-id">{{ $o->id }}</span></td>
            <td>{{ $o->send_to_kitchen_at->format('Y-m-d H:i') }}</td>
            <td>
              <span id="status-{{ $o->id }}"
                    data-status="{{ $o->status }}"
                    class="status-badge @if($o->status=='Pending') status-pending @elseif($o->status=='In-Progress') status-in-progress @else status-completed @endif">
                {{ $o->status }}
              </span>
            </td>
            <td><span class="items-count">{{ $o->items_count }} items</span></td>
            <td><span class="total-amount" id="total-{{ $o->id }}">Rs {{ number_format($o->total(),2) }}</span></td>
            <td>
              <div class="action-buttons">
                <a href="{{ route('orders.show',$o) }}" class="btn btn-view">
                  <i class="fas fa-eye me-1"></i>View
                </a>
                @if($o->status==='Pending')
                  <form class="d-inline send-now-form" method="post" action="{{ route('orders.sendNow',$o) }}" data-order-id="{{ $o->id }}">
                    @csrf
                    <button type="submit" id="sendnow-{{ $o->id }}" class="btn btn-send-now">
                      <i class="fas fa-paper-plane me-1"></i>Send Now
                    </button>
                  </form>
                @endif
                <form class="d-inline" method="post" action="{{ route('orders.destroy',$o) }}">
                  @csrf @method('DELETE')
                  <button class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this order?')">
                    <i class="fas fa-trash me-1"></i>Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
      {{ $orders->links() }}
    </div>
  @else
    <div class="empty-state">
      <i class="fas fa-clipboard-list"></i>
      <h4 class="text-muted mb-3">No Orders Yet</h4>
      <p class="text-muted mb-4">Start creating orders to manage your restaurant operations.</p>
      <a href="{{ route('orders.create') }}" class="btn btn-create-order">
        <i class="fas fa-plus me-2"></i>Create Your First Order
      </a>
    </div>
  @endif
</main>

<script>
(function(){
  const ids = Array.from(document.querySelectorAll('tr[data-order-id]')).map(tr => tr.getAttribute('data-order-id'));
  if (ids.length === 0) return;

  function badgeClass(s){
    return s==='Pending' ? 'status-badge status-pending'
         : s==='In-Progress' ? 'status-badge status-in-progress'
         : 'status-badge status-completed';
  }

  async function refreshStatuses(){
    try{
      const url = "{{ route('orders.statuses') }}" + "?ids=" + ids.join(',') + "&t=" + Date.now();
      const res = await fetch(url,{ headers:{'Accept':'application/json'}, cache:'no-store' });
      if(!res.ok) return;
      const json = await res.json();
      (json.data||[]).forEach(o=>{
        const badge=document.getElementById('status-'+o.id);
        if(badge && badge.dataset.status!==o.status){
          badge.dataset.status=o.status;
          badge.className=badgeClass(o.status);
          badge.textContent=o.status;
          const btn=document.getElementById('sendnow-'+o.id);
          if(btn) btn.style.display = (o.status==='Pending')?'':'none';
        }
        const totalCell=document.getElementById('total-'+o.id);
        if(totalCell && typeof o.total!=='undefined'){
          totalCell.textContent='Rs '+Number(o.total).toFixed(2);
        }
      });
    }catch(e){}
  }
  refreshStatuses();
  setInterval(refreshStatuses,5000);
})();

// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
  const rows = document.querySelectorAll('.orders-table tbody tr');
  rows.forEach((row, index) => {
    row.style.opacity = '0';
    row.style.transform = 'translateX(-20px)';
    setTimeout(() => {
      row.style.transition = 'all 0.6s ease';
      row.style.opacity = '1';
      row.style.transform = 'translateX(0)';
    }, index * 100);
  });
});
</script>

<script>
// Intercept "Send Now" to avoid full page reload
(function(){
  function badgeClass(s){
    return s==='Pending' ? 'status-badge status-pending'
         : s==='In-Progress' ? 'status-badge status-in-progress'
         : 'status-badge status-completed';
  }

  document.addEventListener('submit', async function(e){
    const form = e.target.closest('.send-now-form');
    if(!form) return;
    e.preventDefault();
    const orderId = form.getAttribute('data-order-id');
    const btn = document.getElementById('sendnow-'+orderId);
    if(btn){ btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Sending...'; }

    try{
      const res = await fetch(form.action, { method:'POST', headers:{ 'X-Requested-With':'XMLHttpRequest', 'X-CSRF-TOKEN':'{{ csrf_token() }}' } });
      if(!res.ok){ throw new Error('Request failed'); }
      // Update UI instantly: hide button and set status to In-Progress
      if(btn){ btn.style.display = 'none'; }
      const badge = document.getElementById('status-'+orderId);
      if(badge){
        badge.dataset.status = 'In-Progress';
        badge.className = badgeClass('In-Progress');
        badge.textContent = 'In-Progress';
      }
    }catch(err){
      if(btn){ btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane me-1"></i>Send Now'; }
      alert('Failed to send order. Please try again.');
    }
  });
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
