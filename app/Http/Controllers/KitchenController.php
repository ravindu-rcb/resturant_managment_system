<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;

class KitchenController extends Controller
{
    public function __construct(private OrderRepositoryInterface $orders) {}

    public function index() {
        $orders = $this->orders->getInProgressPaginated();
        return view('kitchen.index', compact('orders'));
    }

    public function updates(Request $request)
    {
        // Known IDs already on the page
        $known = collect(explode(',', (string)$request->query('known')))
            ->filter(fn($v) => is_numeric($v))
            ->map(fn($v) => (int)$v)
            ->values();

        // All current In-Progress orders (what Kitchen should show)
        $orders = Order::with('items.concession')
            ->where('status', 'In-Progress')
            ->orderBy('send_to_kitchen_at')
            ->get();

        // What’s new compared to what the page already shows?
        $new = $orders->whereNotIn('id', $known)->values();

        return response()->json([
            // full list of IDs now in-progress (for syncing if you want)
            'ids' => $orders->pluck('id')->values(),
            // details for only the new ones (to render + notify)
            'new' => $new->map(function ($o) {
                return [
                    'id' => $o->id,
                    'send_to_kitchen_at' => optional($o->send_to_kitchen_at)->format('Y-m-d H:i'),
                    'total' => $o->total(),
                    'items' => $o->items->map(fn($it) => [
                        'name' => $it->concession->name,
                        'quantity' => $it->quantity,
                    ])->values(),
                ];
            }),
        ]);
    }

    public function complete(Order $order) {
        $this->orders->markCompleted($order);
        return back()->with('ok','Order marked Completed.');
    }
}
