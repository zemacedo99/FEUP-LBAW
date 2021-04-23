<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps  = false;
    protected $table = 'item';
    protected $fillable = ['supplier_id', 'name', 'price', 'stock', 'description', 'active', 'rating', 'is_bundle'];

    


    use HasFactory;

    public function supplier(){return $this->belongsTo('App\Models\Supplier');}

    public function tags(){ return $this->belongsToMany('App\Models\Tag');}

    public function client_favorites() { return $this->belongsToMany('App\Models\Client', 'favorite');}

    public function client_carts() { return $this->belongsToMany('App\Models\Client', 'cart')->withPivot('quantity');}

    public function contains_products() { return $this->belongsToMany('App\Models\Product', 'bundle_product', 'bundle_id', 'product_id')->withPivot('quantity');}

    public function purchases() { return $this->belongsToMany('App\Models\Purchase', 'item_info')->withPivot('price', 'amount');}

    public function reviews() { return $this->hasMany('App\Models\Review');}
      
    
}
