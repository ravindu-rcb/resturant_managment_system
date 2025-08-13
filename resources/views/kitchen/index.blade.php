<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Kitchen</title>
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

    .kitchen-stats {
      background: white;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      margin-bottom: 2rem;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
    }

    .stat-item {
      text-align: center;
      padding: 1.5rem;
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      border-radius: 1rem;
      color: #333;
      box-shadow: 0 4px 15px rgba(255, 225, 0, 0.3);
    }

    .stat-value {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary-orange);
      margin-bottom: 0.5rem;
    }

    .stat-label {
      font-size: 1rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
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

    .orders-table tbody tr:last-child td {
      border-bottom: none;
    }

    .order-id {
      font-weight: 700;
      color: var(--primary-orange);
      font-size: 1.2rem;
    }

    .send-time {
      color: #6c757d;
      font-weight: 500;
    }

    .order-items {
      max-width: 300px;
    }

    .order-items ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .order-items li {
      background: var(--accent-cream);
      color: #333;
      padding: 0.5rem 0.75rem;
      margin-bottom: 0.5rem;
      border-radius: 0.5rem;
      font-size: 0.9rem;
      font-weight: 500;
      border-left: 3px solid var(--primary-orange);
    }

    .order-items li:last-child {
      margin-bottom: 0;
    }

    .order-total {
      font-weight: 700;
      color: var(--primary-orange);
      font-size: 1.1rem;
    }

    .btn-complete {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      border: none;
      color: white;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 20px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 10px rgba(40, 167, 69, 0.4);
    }

    .btn-complete:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(40, 167, 69, 0.6);
      color: white;
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
    }

    .pagination .page-link:hover {
      background: var(--accent-gold);
      color: white;
    }

    #toast-box {
      position: fixed;
      top: 2rem;
      right: 2rem;
      z-index: 9999;
      max-width: 400px;
    }

    .toast-item {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      padding: 1rem 1.5rem;
      margin-bottom: 1rem;
      border-radius: 1rem;
      box-shadow: 0 8px 25px rgba(255, 155, 0, 0.3);
      display: flex;
      align-items: center;
      gap: 1rem;
      animation: slideInRight 0.5s ease;
      border: none;
      position: relative;
      overflow: hidden;
    }

    .toast-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #fff, var(--primary-yellow), #fff);
      animation: shimmer 2s infinite;
    }

    .toast-item .close {
      background: transparent;
      border: 0;
      color: white;
      font-size: 1.2rem;
      line-height: 1;
      cursor: pointer;
      padding: 0;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: all 0.3s ease;
      flex-shrink: 0;
    }

    .toast-item .close:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: scale(1.1);
    }

    .toast-item .flex-grow-1 {
      flex: 1;
      font-weight: 500;
    }

    .toast-item .notification-icon {
      font-size: 1.5rem;
      color: var(--primary-yellow);
      flex-shrink: 0;
    }

    @keyframes slideInRight {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes shimmer {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .notification-pulse {
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .kitchen-status {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      color: #333;
      padding: 1rem 1.5rem;
      border-radius: 1rem;
      margin-bottom: 2rem;
      text-align: center;
      box-shadow: 0 4px 15px rgba(255, 225, 0, 0.3);
    }

    .kitchen-status i {
      font-size: 1.5rem;
      margin-right: 0.5rem;
      color: var(--primary-orange);
    }

    .notification-sound-toggle {
      position: fixed;
      top: 2rem;
      left: 2rem;
      z-index: 9998;
      background: rgba(0, 0, 0, 0.8);
      color: white;
      border: none;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 0.9rem;
    }

    .notification-sound-toggle:hover {
      background: rgba(0, 0, 0, 0.9);
      transform: scale(1.05);
    }

    .notification-sound-toggle.muted {
      background: rgba(220, 53, 69, 0.8);
    }

    .notification-sound-toggle.muted:hover {
      background: rgba(220, 53, 69, 0.9);
    }

    @media (max-width: 768px) {
      .orders-table {
        font-size: 0.9rem;
      }

      .orders-table th,
      .orders-table td {
        padding: 0.75rem 0.5rem;
      }

      .order-items {
        max-width: 200px;
      }

      .order-items li {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
      }

      .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .stat-item {
        padding: 1rem;
      }

      .stat-value {
        font-size: 2rem;
      }

      .notification-sound-toggle {
        top: 1rem;
        left: 1rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
      }

      #toast-box {
        top: 1rem;
        right: 1rem;
        max-width: 300px;
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
    <h1 class="page-title">Kitchen Dashboard</h1>
    <p class="page-subtitle">Manage and track in-progress orders</p>
  </div>
</div>

<main class="container">

  <!-- Kitchen Statistics -->
  <div class="kitchen-stats">
    <div class="stats-grid">
      <div class="stat-item">
        <div class="stat-value" id="activeOrders">{{ $orders->count() }}</div>
        <div class="stat-label">Active Orders</div>
      </div>
      <div class="stat-item">
        <div class="stat-value" id="totalItems">{{ $orders->sum(function($order) { return $order->items->sum('quantity'); }) }}</div>
        <div class="stat-label">Total Items</div>
      </div>
      <div class="stat-item">
        <div class="stat-value" id="totalValue">Rs {{ number_format($orders->sum(function($order) { return $order->total(); }), 2) }}</div>
        <div class="stat-label">Total Value</div>
      </div>
    </div>
  </div>

  <!-- Orders Table -->
  @if($orders->count())
    <div class="table-responsive">
      <table class="table orders-table">
        <thead>
          <tr>
            <th><i class="fas me-2"></i>Order ID</th>
            <th><i class="fas me-2"></i>Send Time</th>
            <th><i class="fas me-2"></i>Items</th>
            <th><i class="fas me-2"></i>Total</th>
            <th><i class="fas me-2"></i>Action</th>
          </tr>
        </thead>
        <tbody id="kitchen-table-body">
          @foreach($orders as $o)
            <tr id="order-row-{{ $o->id }}" data-order-id="{{ $o->id }}">
              <td><span class="order-id">{{ $o->id }}</span></td>
              <td><span class="send-time">{{ $o->send_to_kitchen_at->format('Y-m-d H:i') }}</span></td>
              <td>
                <div class="order-items">
                  <ul>
                    @foreach($o->items as $it)
                      <li>{{ $it->concession->name }} (x{{ $it->quantity }})</li>
                    @endforeach
                  </ul>
                </div>
              </td>
              <td><span class="order-total">Rs {{ number_format($o->total(),2) }}</span></td>
              <td>
                <form method="post" action="{{ route('kitchen.complete',$o) }}">
                  @csrf
                  <button class="btn btn-complete">
                    <i class="fas fa-check me-1"></i>Mark Completed
                  </button>
                </form>
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
      <i class="fas fa-utensils"></i>
      <h4 class="text-muted mb-3">No Active Orders</h4>
      <p class="text-muted mb-4">Kitchen is ready for new orders. All current orders have been completed.</p>
    </div>
  @endif
</main>

<!-- Notification Sound Toggle Button -->
<button class="notification-sound-toggle" id="soundToggle" title="Toggle notification sound">
  <i class="fas fa-volume-up"></i> Sound ON
</button>

<div id="toast-box"></div>

<!-- Enhanced audio with multiple sound options -->
<audio id="kitchen-chime" preload="auto">
  <source src="data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEAESsAACJWAAACABYAAAACAAACAAA=" type="audio/wav">
</audio>

<audio id="notification-bell" preload="auto">
  <source src="data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEAESsAACJWAAACABYAAAACAAACAAA=" type="audio/wav">
</audio>

<script>
(function () {
  const tbody = document.getElementById('kitchen-table-body');
  const chime = document.getElementById('kitchen-chime');
  const bell = document.getElementById('notification-bell');
  const soundToggle = document.getElementById('soundToggle');
  let soundEnabled = true;
  let notificationCount = 0;

  // Sound toggle functionality
  soundToggle.addEventListener('click', function() {
    soundEnabled = !soundEnabled;
    if (soundEnabled) {
      this.innerHTML = '<i class="fas fa-volume-up"></i> Sound ON';
      this.classList.remove('muted');
      this.title = 'Toggle notification sound';
    } else {
      this.innerHTML = '<i class="fas fa-volume-mute"></i> Sound OFF';
      this.classList.add('muted');
      this.title = 'Toggle notification sound';
    }
  });

  function ensureToastBox(){
    let box = document.getElementById('toast-box');
    if(!box){
      box = document.createElement('div');
      box.id = 'toast-box';
      document.body.appendChild(box);
    }
    return box;
  }

  function showToast(msg, orderId){
    const box = ensureToastBox();
    const el = document.createElement('div');
    el.className = 'toast-item notification-pulse';
    el.id = `notification-${orderId}`;
    el.innerHTML = `
      <i class="fas fa-bell notification-icon"></i>
      <span class="flex-grow-1">${msg}</span>
      <button class="close" aria-label="Close" onclick="closeNotification(${orderId})">&times;</button>
    `;
    box.appendChild(el);

    // Play notification sound if enabled
    if (soundEnabled) {
      try {
        // Try to play the bell sound first, fallback to chime
        if (bell && bell.play) {
          bell.play().catch(() => {
            if (chime && chime.play) chime.play().catch(e => {});
          });
        } else if (chime && chime.play) {
          chime.play().catch(e => {});
        }
      } catch(e) {}
    }

    notificationCount++;
    updateNotificationCount();
  }

  function closeNotification(orderId) {
    const notification = document.getElementById(`notification-${orderId}`);
    if (notification) {
      notification.remove();
      notificationCount--;
      updateNotificationCount();
    }
  }

  function updateNotificationCount() {
    const toggle = document.getElementById('soundToggle');
    if (notificationCount > 0) {
      toggle.innerHTML = `<i class="fas fa-volume-up"></i> Sound ON (${notificationCount})`;
    } else {
      toggle.innerHTML = '<i class="fas fa-volume-up"></i> Sound ON';
    }
  }

  function currentIds() {
    return Array.from(document.querySelectorAll('#kitchen-table-body tr[data-order-id]'))
      .map(tr => tr.getAttribute('data-order-id'));
  }

  function addRow(order) {
    const empty = document.getElementById('kitchen-empty');
    if (empty) empty.remove();

    const tr = document.createElement('tr');
    tr.id = 'order-row-' + order.id;
    tr.setAttribute('data-order-id', order.id);

    const itemsHtml = (order.items || []).map(i => `<li>${i.name} (x${i.quantity})</li>`).join('');
    tr.innerHTML = `
      <td><span class="order-id">#${order.id}</span></td>
      <td><span class="send-time">${order.send_to_kitchen_at || ''}</span></td>
      <td>
        <div class="order-items">
          <ul>${itemsHtml}</ul>
        </div>
      </td>
      <td><span class="order-total">Rs ${Number(order.total).toFixed(2)}</span></td>
      <td>
        <form method="post" action="/kitchen/${order.id}/complete">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="btn btn-complete">
            <i class="fas fa-check me-1"></i>Mark Completed
          </button>
        </form>
      </td>
    `;

    // Add animation
    tr.style.opacity = '0';
    tr.style.transform = 'translateX(-20px)';

    if (tbody.firstChild) tbody.insertBefore(tr, tbody.firstChild);
    else tbody.appendChild(tr);

    // Animate in
    setTimeout(() => {
      tr.style.transition = 'all 0.6s ease';
      tr.style.opacity = '1';
      tr.style.transform = 'translateX(0)';
    }, 100);
  }

  async function poll() {
    try {
      const ids = currentIds();
      const url = "{{ route('kitchen.updates') }}" + "?known=" + ids.join(',') + "&t=" + Date.now();
      const res = await fetch(url, { headers:{ 'Accept':'application/json' }, cache:'no-store' });
      if (!res.ok) return;
      const data = await res.json();
      (data.new || []).forEach(o => {
        addRow(o);
        showToast(` New order ${o.id} sent to kitchen!`, o.id);
      });
    } catch (e) {}
  }

  // Add smooth animations
  document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#kitchen-table-body tr');
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

  // Make closeNotification function globally available
  window.closeNotification = closeNotification;

  poll();
  setInterval(poll, 5000);
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
