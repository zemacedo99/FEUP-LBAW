<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BundleProduct extends Model
{
    public $timestamps  = false;
    protected $table = 'bundle_product';
    use HasFactory;
}
