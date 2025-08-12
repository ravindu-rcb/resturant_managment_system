<?php

namespace App\Console\Commands;

use App\Repositories\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DispatchScheduledOrders extends Command
{
    protected $signature = 'orders:dispatch-scheduled';
    protected $description = 'Dispatch Pending orders whose send_to_kitchen_at is due';

    public function handle(OrderRepositoryInterface $orders): int
    {
        $now = Carbon::now();
        foreach ($orders->duePendingOrders($now) as $o) {
            // queue job onto "kitchen" queue
            \App\Jobs\SendOrderToKitchen::dispatch($o->id)->onQueue('kitchen');
        }
        $this->info('Dispatched due orders.');
        return self::SUCCESS;
    }
}
