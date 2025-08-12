<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\ConcessionRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepositoryInterface $orders,
        private ConcessionRepositoryInterface $concessions
    ) {}

    public function statuses(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids')))
            ->filter(fn($v) => is_numeric($v))
            ->map(fn($v) => (int) $v)
            ->values();

        if ($ids->isEmpty()) {
            return response()->json(['data' => []]);
        }

        // get the orders shown on the current page
        $orders = \App\Models\Order::whereIn('id', $ids)->get();

        // build a small payload
        $payload = $orders->map(function ($o) {
            return [
                'id' => $o->id,
                'status' => $o->status,
                'send_to_kitchen_at' => optional($o->send_to_kitchen_at)->format('Y-m-d H:i'),
                'total' => $o->total(),
            ];
        });

        return response()->json(['data' => $payload]);
    }

    public function index() {
        $orders = $this->orders->paginate();
        return view('orders.index', compact('orders'));
    }

    public function create() {
        $concessions = $this->concessions->all();
        return view('orders.create', compact('concessions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',                // items[id] = qty
            'items.*' => 'integer|min:1',
            'send_to_kitchen_at' => 'required|date',
        ]);

        // create order
        $order = \App\Models\Order::create([
            'send_to_kitchen_at' => $data['send_to_kitchen_at'],
            'status' => 'Pending',
        ]);

        // line items (one row per product with quantity)
        $concessions = \App\Models\Concession::whereIn('id', array_keys($data['items']))->get()->keyBy('id');

        foreach ($data['items'] as $id => $qty) {
            if (!isset($concessions[$id])) continue;
            \App\Models\OrderItem::create([
                'order_id'      => $order->id,
                'concession_id' => $id,
                'quantity'      => (int)$qty,
                'price'         => $concessions[$id]->price, // snapshot
            ]);
        }

        return redirect()->route('orders.index')->with('ok', 'Order created.');
    }

    public function show(Order $order) {
        $order = $this->orders->findWithItems($order->id);
        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order) {
        $this->orders->delete($order);
        return back()->with('ok','Order deleted.');
    }

    public function sendNow(Order $order) {
        $this->orders->sendNow($order);
        return back()->with('ok','Order sent to kitchen.');
    }
}
