<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPurchase extends Model
{
    protected $table = 'temp_purchases';
    public $timestamps  = false;

    protected $fillable = ['id', 'client_id', 'total', 'type'];

    use HasFactory;

    public function client() { return $this->belongsTo('App\Models\Client');}
    
}
