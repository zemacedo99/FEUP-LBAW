<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipDetail extends Model
{
    public $timestamps  = false;
    protected $fillable = [ 'first_name',
                            'last_name',
                            'address',
                            'door_n',
                            'post_code',
                            'district',
                            'city',
                            'country',
                            'phone_n',
                            'client_id'];

    use HasFactory;

    public function client() { return $this->belongsTo('App\Models\Client');}

}
