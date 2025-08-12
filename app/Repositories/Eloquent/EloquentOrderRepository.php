<?php

namespace App\Repositories\Eloquent;

use App\Jobs\SendOrderToKitchen;
use App\Models\Concession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Order::withCount('items')->latest()->paginate($perPage);
    }

    public function findWithItems(int $id): ?Order
    {
        return Order::with('items.concession')->find($id);
    }

    public function createOrder(array $concessionIds, string $sendToKitchenAt): Order
    {
        return DB::transaction(function () use ($concessionIds, $sendToKitchenAt) {
            $order = Order::create([
                'send_to_kitchen_at' => $sendToKitchenAt,
                'status' => 'Pending',
            ]);
            $items = Concession::whereIn('id', $concessionIds)->get();
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'concession_id' => $item->id,
                    'quantity'      => 1,
                    'price'         => $item->price, // snapshot
                ]);
            }
            return $order;
        });
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }

    public function sendNow(Order $order): void
    {
        if ($order->status === 'Pending') {
            SendOrderToKitchen::dispatch($order->id)->onQueue('kitchen');
        }
    }

    public function markInProgress(int $orderId): void
    {
        $o = Order::find($orderId);
        if ($o && $o->status === 'Pending') {
            $o->update(['status' => 'In-Progress']);
        }
    }

    public function markCompleted(Order $order): void
    {
        if ($order->status === 'In-Progress') {
            $order->update(['status' => 'Completed']);
        }
    }

    public function getInProgressPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Order::with('items.concession')
            ->where('status', 'In-Progress')
            ->orderBy('send_to_kitchen_at')
            ->paginate($perPage);
    }

    public function duePendingOrders(Carbon $asOf): iterable
    {
        return Order::where('status', 'Pending')
            ->where('send_to_kitchen_at', '<=', $asOf)
            ->orderBy('send_to_kitchen_at')
            ->cursor();
    }
}
