<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * establish relationship with OrderItem
     *
     * @return void
     */
    public function OrderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
}
