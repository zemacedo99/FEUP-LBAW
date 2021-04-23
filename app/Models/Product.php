<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps  = false;
    protected $table = 'product';
    protected $fillable = ['type'];


    use HasFactory;

    public function is_part_of() {return $this->belongsToMany('App\Models\Item', 'bundle_product', 'bundle_id', 'product_id')->withPivot('quantity');}

    public function images() {return $this->belongsToMany('App\Models\Image');}    
}
