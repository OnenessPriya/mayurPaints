<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTxn extends Model
{
    public function users() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
