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

    public function store(Request $request) {
        $data = $request->validate([
            'concessions' => 'required|array|min:1',
            'concessions.*' => 'exists:concessions,id',
            'send_to_kitchen_at' => 'required|date',
        ]);
        $this->orders->createOrder($data['concessions'], $data['send_to_kitchen_at']);
        return redirect()->route('orders.index')->with('ok','Order created.');
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
