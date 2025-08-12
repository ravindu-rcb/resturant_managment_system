<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = ['send_to_kitchen_at','status'];
    protected $casts = ['send_to_kitchen_at' => 'datetime'];

    public function items(): HasMany { return $this->hasMany(OrderItem::class); }

    public function total(): float {
        return (float) ($this->items()->select(DB::raw('SUM(price * quantity) t'))->value('t') ?? 0);
    }
}

