<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps  = false;
    protected $table = 'client';
    use HasFactory;

    public function credit_card() { return $this->hasMany('App\Models\CreditCard');}

    public function review() { return $this->hasMany('App\Models\Review');}

    public function ship_detail() { return $this->hasMany('App\Models\ShipDetail');}
}
