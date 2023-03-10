<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquery extends Model
{
    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function userDetails() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
