<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipDetail extends Model
{
    public $timestamps  = false;
    protected $table = 'ship_detail';
    use HasFactory;

    public function client() { return $this->belongsTo('App\Models\Client');}

}
