<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps  = false;
    protected $table = 'purchase';
    protected $fillable = ['client_id', 'paid', 'purchase_date', 'type'];

    use HasFactory;
    

    public function buyer(){return $this->belongsTo('App\Models\Shopper');}

    public function items() {return $this->belongsToMany('App\Models\Item', 'item_info')->withPivot('price', 'amount');}
}
