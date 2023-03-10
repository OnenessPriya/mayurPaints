<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderProducts() {
        return $this->belongsTo('App\Models\RewardProduct', 'product_id', 'id');
    }
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
