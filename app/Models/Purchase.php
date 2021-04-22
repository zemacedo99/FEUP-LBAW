<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps  = false;
    protected $table = 'purchase';
    use HasFactory;

    public function buyer(){return $this->belongsTo('App\Models\Shopper');}

    public function items(){return $this->hasMany('App\Models\Item');}
                            //$this->belongsToMany('App\Models\Person')->withPivot('price','amount');}
}
