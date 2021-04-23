<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps  = false;
    protected $table = 'coupon';
    protected $fillable = ['name'];


    use HasFactory;


    public function owner(){return $this->belongsTo('App\Models\Supplier');}
}
