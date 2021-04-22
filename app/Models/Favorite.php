<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps  = false;
    protected $table = 'favorite';
    use HasFactory;


    public function owner(){return $this->belongsTo('App\Models\Shopper');}

    public function item(){return $this->hasOne('App\Models\Item');}
}
