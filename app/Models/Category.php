<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function ProductDetails() {
        return $this->hasMany('App\Models\Product', 'cat_id', 'id');
    }
}
