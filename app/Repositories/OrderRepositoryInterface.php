<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

interface OrderRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function findWithItems(int $id): ?Order;
    public function createOrder(array $concessionIds, string $sendToKitchenAt): Order;
    public function delete(Order $order): void;

    // kitchen flow
    public function sendNow(Order $order): void;
    public function markInProgress(int $orderId): void;
    public function markCompleted(Order $order): void;
    public function getInProgressPaginated(int $perPage = 15): LengthAwarePaginator;
    public function duePendingOrders(Carbon $asOf): iterable;
}
