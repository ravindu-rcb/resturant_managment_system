<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} — Kitchen</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    #toast-box{position:fixed; top:16px; right:16px; z-index:9999;}
    .toast-item{
      background:#0d6efd; color:#fff; padding:10px 14px; margin-bottom:10px;
      border-radius:6px; box-shadow:0 4px 12px rgba(0,0,0,.15);
      display:flex; align-items:center; gap:10px;
    }
    .toast-item .close{background:transparent; border:0; color:#fff; font-size:18px; line-height:1; cursor:pointer;}
  </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <div class="navbar-nav">
      <a class="nav-link" href="{{ route('concessions.index') }}">Concessions</a>
      <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
      <a class="nav-link active" href="{{ route('kitchen.index') }}">Kitchen</a>
    </div>
  </div>
</nav>
<main class="container py-4">
  <h3>Kitchen – In-Progress Orders</h3>

  <div id="toast-box"></div>

  <audio id="kitchen-chime" preload="auto">
    <source src="data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEAESsAACJWAAACABYAAAACAAACAAA=" type="audio/wav">
  </audio>

  <table class="table table-striped">
    <thead><tr><th>#</th><th>Send Time</th><th>Items</th><th>Total</th><th>Action</th></tr></thead>
    <tbody id="kitchen-table-body">
    @forelse($orders as $o)
      <tr id="order-row-{{ $o->id }}" data-order-id="{{ $o->id }}">
        <td>{{ $o->id }}</td>
        <td>{{ $o->send_to_kitchen_at->format('Y-m-d H:i') }}</td>
        <td>
          <ul class="mb-0">
            @foreach($o->items as $it)
              <li>{{ $it->concession->name }} (x{{ $it->quantity }})</li>
            @endforeach
          </ul>
        </td>
        <td>Rs {{ number_format($o->total(),2) }}</td>
        <td>
          <form method="post" action="{{ route('kitchen.complete',$o) }}">
            @csrf <button class="btn btn-success btn-sm">Mark Completed</button>
          </form>
        </td>
      </tr>
    @empty
      <tr id="kitchen-empty"><td colspan="5" class="text-center text-muted">No orders yet.</td></tr>
    @endforelse
    </tbody>
  </table>
  {{ $orders->links() }}
</main>

<script>
(function () {
  const tbody  = document.getElementById('kitchen-table-body');
  const chime  = document.getElementById('kitchen-chime');

  function ensureToastBox(){
    let box = document.getElementById('toast-box');
    if(!box){
      box = document.createElement('div');
      box.id = 'toast-box';
      box.style.cssText = 'position:fixed; top:16px; right:16px; z-index:9999;';
      document.body.appendChild(box);
    }
    return box;
  }
  function showToast(msg){
    const box = ensureToastBox();
    const el  = document.createElement('div');
    el.className = 'toast-item';
    el.innerHTML = `<span class="flex-grow-1">${msg}</span>
                    <button class="close" aria-label="Close">&times;</button>`;
    el.querySelector('.close').onclick = () => el.remove();
    box.appendChild(el);
    setTimeout(() => el.remove(), 6000);
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
      <td>${order.id}</td>
      <td>${order.send_to_kitchen_at || ''}</td>
      <td><ul class="mb-0">${itemsHtml}</ul></td>
      <td>Rs ${Number(order.total).toFixed(2)}</td>
      <td>
        <form method="post" action="/kitchen/${order.id}/complete">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="btn btn-success btn-sm">Mark Completed</button>
        </form>
      </td>
    `;
    if (tbody.firstChild) tbody.insertBefore(tr, tbody.firstChild);
    else tbody.appendChild(tr);
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
        showToast(`New order #${o.id} sent to kitchen`);
        try { chime && chime.play && chime.play(); } catch(e) {}
      });
    } catch (e) {}
  }
  poll();
  setInterval(poll, 5000);
})();
</script>
</body>
</html>
