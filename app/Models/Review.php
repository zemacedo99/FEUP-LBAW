<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps  = false;
    protected $fillable = ['client_id', 'item_id', 'rating', 'description'];

    use HasFactory;

    public function client() { return $this->belongsTo('App\Models\Client');}

    public function item() { return $this->belongsTo('App\Models\Item');}
}
