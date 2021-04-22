<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps  = false;
    protected $table = 'item';

    use HasFactory;

    public function images(){return $this->hasMany('App\Models\Image');}

    public function supplier(){return $this->belongsTo('App\Models\Supplier');}

    
}
