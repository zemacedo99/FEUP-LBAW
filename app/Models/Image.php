<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps  = false;
    protected $table = 'image';
    
    use HasFactory;

    public function supplier() { return $this->hasOne('App\Models\Supplier');}

    public function client() { return $this->hasOne('App\Models\Client');}

    public function products() { return $this->belongsTo('App\Models\Product');}
}
