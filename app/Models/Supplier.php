<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $timestamps  = false;
    protected $fillable = ['id', 'name', 'address', 'post_code', 'city', 'description', 'accepted', 'image_id'];

    use HasFactory;

    public function items(){return $this->hasMany('App\Models\Item');}

    public function coupons(){return $this->hasMany('App\Models\Coupon');}

    public function image(){return $this->belongsTo('App\Models\Image');}
}
