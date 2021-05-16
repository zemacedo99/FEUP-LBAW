<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    public $timestamps  = false;
    protected $fillable = ['cc_id', 'card_n', 'expiration', 'cvv', 'holder', 'client_id'];
    protected $table = "credit_cards";

    use HasFactory;

    public function client() { return $this->belongsTo('App\Models\Client');}

}
