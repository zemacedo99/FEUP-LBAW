<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps  = false;
    protected $fillable = ['id', 'code', 'name', 'description', 'expiration', 'type', 'amount', 'supplier_id'];

    public function owner(){return $this->belongsTo('App\Models\Supplier');}
}
