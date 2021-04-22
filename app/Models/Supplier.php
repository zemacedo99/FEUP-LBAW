<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $timestamps  = false;
    protected $table = 'supplier';
    use HasFactory;

    public function itens(){return $this->hasMany('App\Models\Item');}

    public function coupons(){return $this->hasMany('App\Models\Coupon');}

    public function image(){return $this->hasOne('App\Models\Image');}


}
