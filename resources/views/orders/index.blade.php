@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Orders</h3>
  <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>
</div>
<table class="table table-bordered">
  <thead><tr><th>#</th><th>Send to Kitchen</th><th>Status</th><th>Items</th><th>Total</th><th></th></tr></thead>
  <tbody>
    @foreach($orders as $o)
    <tr id="order-row-{{ $o->id }}" data-order-id="{{ $o->id }}">
        <td>{{ $o->id }}</td>
        <td>{{ $o->send_to_kitchen_at->format('Y-m-d H:i') }}</td>
        <td>
        <span id="status-{{ $o->id }}"
                data-status="{{ $o->status }}"
                class="badge
                @if($o->status=='Pending') bg-warning
                @elseif($o->status=='In-Progress') bg-info
                @else bg-success @endif">
            {{ $o->status }}
        </span>
        </td>
        <td id="items-{{ $o->id }}">{{ $o->items_count }}</td>
        <td id="total-{{ $o->id }}">Rs {{ number_format($o->total(),2) }}</td>
        <td class="text-end">
        <a href="{{ route('orders.show',$o) }}" class="btn btn-sm btn-secondary">View</a>
        @if($o->status==='Pending')
            <form class="d-inline" method="post" action="{{ route('orders.sendNow',$o) }}">
            @csrf
            <button id="sendnow-{{ $o->id }}" class="btn btn-sm btn-primary">Send Now</button>
            </form>
        @endif
        <form class="d-inline" method="post" action="{{ route('orders.destroy',$o) }}">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete order?')">Delete</button>
        </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection

@push('scripts')
<script>
(function(){
  // collect IDs displayed on this page
  const ids = Array.from(document.querySelectorAll('tr[data-order-id]'))
    .map(tr => tr.getAttribute('data-order-id'));

  if (ids.length === 0) return;

  function badgeClass(status){
    if(status === 'Pending') return 'badge bg-warning';
    if(status === 'In-Progress') return 'badge bg-info';
    return 'badge bg-success';
  }

  async function refreshStatuses(){
    try{
      const url = "{{ route('orders.statuses') }}" + "?ids=" + ids.join(',');
      const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
      if(!res.ok) return;
      const json = await res.json();

      (json.data || []).forEach(o => {
        // status badge
        const badge = document.getElementById('status-' + o.id);
        if (badge && badge.dataset.status !== o.status){
          badge.dataset.status = o.status;
          badge.className = badgeClass(o.status);
          badge.textContent = o.status;

          // hide Send Now button if no longer Pending
          const btn = document.getElementById('sendnow-' + o.id);
          if (btn) {
            if (o.status !== 'Pending') { btn.style.display = 'none'; }
            else { btn.style.display = ''; }
          }
        }

        // total (optional to refresh)
        const totalCell = document.getElementById('total-' + o.id);
        if (totalCell && typeof o.total !== 'undefined') {
          totalCell.textContent = 'Rs ' + (Number(o.total).toFixed(2));
        }
      });
    }catch(e){ /* silent */ }
  }

  // poll every 5 seconds
  refreshStatuses();
  setInterval(refreshStatuses, 5000);
})();
</script>
@endpush

