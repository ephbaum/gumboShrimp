<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function OrderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
}
