<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    public $timestamps  = false;
    protected $table = 'credit_card';
    protected $fillable = ['cc_id', 'card_n', 'expiration', 'cvv', 'holder', 'client_id'];


    use HasFactory;

    public function client() { return $this->belongsTo('App\Models\Client');}

}
