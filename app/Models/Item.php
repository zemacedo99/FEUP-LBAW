<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    public $timestamps  = false;
    protected $fillable = ['supplier_id', 'name', 'price', 'stock', 'description', 'active', 'rating', 'is_bundle'];

    use HasFactory;

    public function supplier(){return $this->belongsTo('App\Models\Supplier');}

    public function tags(){ return $this->belongsToMany('App\Models\Tag');}

    public function client_favorites() { return $this->belongsToMany('App\Models\Client');}

    public function client_carts() { return $this->belongsToMany('App\Models\Client', 'carts')->withPivot('quantity');}

    public function contains_products() { return $this->belongsToMany('App\Models\Product')->withPivot('quantity');}

    public function purchases() { return $this->belongsToMany('App\Models\Purchase')->withPivot('price', 'amount');}

    public function reviews() { return $this->hasMany('App\Models\Review');}

    public function product() {
        if ($this->is_bundle == false){
            return Product::find($this->id);
        }
        return null;
    }
}
