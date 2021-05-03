<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps  = false;
    protected $fillable = ['client_id', 'paid', 'purchase_date', 'type'];

    use HasFactory;


    public function buyer(){return $this->belongsTo('App\Models\Client');}

    public function items() {return $this->belongsToMany('App\Models\Item')->withPivot('price', 'amount');}
}
