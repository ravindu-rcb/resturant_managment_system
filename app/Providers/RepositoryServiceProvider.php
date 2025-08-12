<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ConcessionRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\Eloquent\EloquentConcessionRepository;
use App\Repositories\Eloquent\EloquentOrderRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ConcessionRepositoryInterface::class, EloquentConcessionRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, EloquentOrderRepository::class);
    }
    public function boot(): void {}
}
