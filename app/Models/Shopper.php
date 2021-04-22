<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopper extends Model
{
    public $timestamps  = false;
    protected $table = 'shopper';
    
    use HasFactory;


    public function cart(){return $this->hasOne('App\Models\Cart');}

}
