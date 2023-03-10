<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    public function userDetails() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
