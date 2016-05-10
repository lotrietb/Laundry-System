<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaundryPickup extends Model
{
     protected $fillable = ['pickup_datetime','address','location'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
