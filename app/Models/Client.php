<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps  = false;
    protected $fillable = ['name'];

    use HasFactory;

    public function credit_card() { return $this->hasMany('App\Models\CreditCard');}

    public function review() { return $this->hasMany('App\Models\Review');}

    public function ship_detail() { return $this->hasOne('App\Models\ShipDetail');}

    public function item_favorites() {return $this->belongsToMany('App\Models\Item');}

    public function item_carts() {return $this->belongsToMany('App\Models\Item', 'carts')
        ->withPivot('quantity');}

    public function image(){return $this->belongsTo('App\Models\Image');}
}
