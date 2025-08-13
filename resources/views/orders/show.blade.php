<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Order #{{ $order->id }}</title>
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

    .order-info-card {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .order-info-header {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      padding: 1.5rem;
      border: none;
    }

    .order-info-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 0;
    }

    .order-info-body {
      padding: 1.5rem;
    }

    .info-row {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
      padding: 1rem;
      background: #f8f9fa;
      border-radius: 0.75rem;
      border-left: 4px solid var(--primary-orange);
    }

    .info-row:last-child {
      margin-bottom: 0;
    }

    .info-icon {
      width: 40px;
      height: 40px;
      background: var(--primary-orange);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      margin-right: 1rem;
      flex-shrink: 0;
    }

    .info-content {
      flex: 1;
    }

    .info-label {
      font-weight: 600;
      color: #6c757d;
      font-size: 0.9rem;
      margin-bottom: 0.25rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .info-value {
      font-size: 1.1rem;
      font-weight: 600;
      color: #2c3e50;
      margin: 0;
    }

    .status-badge {
      padding: 8px 16px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: inline-block;
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

    .order-items-card {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .order-items-header {
      background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-gold) 100%);
      color: #333;
      padding: 1.5rem;
      border: none;
    }

    .order-items-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 0;
    }

    .order-items-body {
      padding: 1.5rem;
    }

    .items-table {
      margin: 0;
    }

    .items-table thead {
      background: #f8f9fa;
    }

    .items-table th {
      border: none;
      padding: 1rem;
      font-weight: 600;
      color: #2c3e50;
      font-size: 1rem;
    }

    .items-table td {
      padding: 1rem;
      border: none;
      border-bottom: 1px solid #f1f3f4;
      vertical-align: middle;
    }

    .items-table tbody tr:last-child td {
      border-bottom: none;
    }

    .items-table tbody tr:hover {
      background: #f8f9fa;
    }

    .item-name {
      font-weight: 600;
      color: #2c3e50;
    }

    .item-quantity {
      background: var(--accent-cream);
      color: #333;
      padding: 6px 12px;
      border-radius: 15px;
      font-weight: 600;
      font-size: 0.9rem;
      text-align: center;
    }

    .item-price {
      color: #6c757d;
      font-weight: 500;
    }

    .item-subtotal {
      font-weight: 700;
      color: var(--primary-orange);
    }

    .total-row {
      background: linear-gradient(135deg, var(--primary-orange) 0%, var(--accent-gold) 100%);
      color: white;
      font-weight: 700;
    }

    .total-row td {
      color: white;
      font-size: 1.2rem;
    }

    .btn-back {
      background: #6c757d;
      border: none;
      color: white;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 25px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
    }

    .btn-back:hover {
      background: #5a6268;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(108, 117, 125, 0.6);
      color: white;
    }

    .order-summary {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      padding: 1.5rem;
      margin-bottom: 2rem;
    }

    .summary-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 1rem;
      text-align: center;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
    }

    .summary-item {
      text-align: center;
      padding: 1rem;
      background: #f8f9fa;
      border-radius: 0.75rem;
      border-left: 4px solid var(--primary-orange);
    }

    .summary-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-orange);
      margin-bottom: 0.25rem;
    }

    .summary-label {
      font-size: 0.9rem;
      color: #6c757d;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
      .info-row {
        flex-direction: column;
        text-align: center;
      }

      .info-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
      }

      .summary-grid {
        grid-template-columns: 1fr;
      }

      .items-table {
        font-size: 0.9rem;
      }

      .items-table th,
      .items-table td {
        padding: 0.75rem 0.5rem;
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
    <h1 class="page-title">Order {{ $order->id }}</h1>
    <p class="page-subtitle">Order details</p>
  </div>
</div>

<main class="container">
  <!-- Order Information -->
  <div class="order-info-card">
    <div class="order-info-header">
      <h2 class="order-info-title">
        <i class="fas fa-info-circle me-2"></i>Order Information
      </h2>
    </div>
    <div class="order-info-body">
      <div class="row">
        <div class="col-md-6">
          <div class="info-row">
            <div class="info-icon">
              <i class="fas fa-hashtag"></i>
            </div>
            <div class="info-content">
              <div class="info-label">Order ID</div>
              <div class="info-value">{{ $order->id }}</div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-row">
            <div class="info-icon">
              <i class="fas fa-clock"></i>
            </div>
            <div class="info-content">
              <div class="info-label">Send to Kitchen</div>
              <div class="info-value">{{ $order->send_to_kitchen_at->format('Y-m-d H:i') }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="info-row">
            <div class="info-icon">
              <i class="fas fa-info-circle"></i>
            </div>
            <div class="info-content">
              <div class="info-label">Status</div>
              <div class="info-value">
                @php $s = $order->status; @endphp
                <span class="status-badge {{ $s==='Pending' ? 'status-pending' : ($s==='In-Progress' ? 'status-in-progress' : 'status-completed') }}">
                  {{ $s }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-row">
            <div class="info-icon">
              <i class="fas fa-box"></i>
            </div>
            <div class="info-content">
              <div class="info-label">Total Items</div>
              <div class="info-value">{{ $order->items->count() }} items</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Summary -->
  <div class="order-summary">
    <h3 class="summary-title">
      <i class="fas me-2"></i>Order Summary
    </h3>
    <div class="summary-grid">
      <div class="summary-item">
        <div class="summary-value">{{ $order->items->count() }}</div>
        <div class="summary-label">Total Items</div>
      </div>
      <div class="summary-item">
        <div class="summary-value">Rs {{ number_format($order->total(),2) }}</div>
        <div class="summary-label">Total Amount</div>
      </div>
      <div class="summary-item">
        <div class="summary-value">{{ $order->send_to_kitchen_at->format('M d, Y') }}</div>
        <div class="summary-label">Order Date</div>
      </div>
      <div class="summary-item">
        <div class="summary-value">{{ $order->send_to_kitchen_at->format('H:i') }}</div>
        <div class="summary-label">Order Time</div>
      </div>
    </div>
  </div>

  <!-- Order Items -->
  <div class="order-items-card">
    <div class="order-items-header">
      <h2 class="order-items-title">
        <i class="fas fa-list me-2"></i>Order Items
      </h2>
    </div>
    <div class="order-items-body">
      <div class="table-responsive">
        <table class="table items-table">
          <thead>
            <tr>
              <th><i class="fas me-2"></i>Item</th>
              <th><i class="fas me-2"></i>Quantity</th>
              <th><i class="fas me-2"></i>Price</th>
              <th><i class="fas me-2"></i>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $it)
              <tr>
                <td><span class="item-name">{{ $it->concession->name }}</span></td>
                <td><span class="item-quantity">{{ $it->quantity }}</span></td>
                <td><span class="item-price">Rs {{ number_format($it->price,2) }}</span></td>
                <td><span class="item-subtotal">Rs {{ number_format($it->price * $it->quantity,2) }}</span></td>
              </tr>
            @endforeach
          </tbody>

        </table>
      </div>
    </div>
  </div>

  <!-- Back Button -->
  <div class="text-center">
    <a href="{{ route('orders.index') }}" class="btn btn-back">
      <i class="fas fa-arrow-left me-2"></i>Back to Orders
    </a>
  </div>
</main>

<script>
// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.order-info-card, .order-summary, .order-items-card');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    setTimeout(() => {
      card.style.transition = 'all 0.8s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 200);
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
