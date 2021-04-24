<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps  = false;
    protected $fillable = ['path'];

    
    use HasFactory;

    public function supplier() { return $this->hasOne('App\Models\Supplier');}

    public function client() { return $this->hasOne('App\Models\Client');}

    public function products() { return $this->belongsToMany('App\Models\Product');}
}
