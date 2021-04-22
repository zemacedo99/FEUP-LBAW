<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemInfo extends Model
{
    public $timestamps  = false;
    protected $table = 'item_info';
    use HasFactory;
}
