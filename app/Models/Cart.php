<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps  = false;
    protected $table = 'cart';
    use HasFactory;


    public function owner(){return $this->belongsTo('App\Models\Shopper');}

    public function items(){return $this->hasMany('App\Models\Item');}
    
}
