<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps  = false;
    protected $fillable = ['path'];


    use HasFactory;

    /* Shopper and Image is one to many
     * An image can belong to many shoppers (Has default value 1)
     * A Shopper can only have 1 image
     */
    public function supplier() { return $this->hasMany('App\Models\Supplier');}

    public function client() { return $this->hasMany('App\Models\Client');}

    /*
     * Each Product has many images
     * But each image belongs to one product
     */
    public function products() { return $this->belongsToMany('App\Models\Product');}
}
