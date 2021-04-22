<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagItem extends Model
{
    public $timestamps  = false;
    protected $table = 'tag_item';
    use HasFactory;
}
