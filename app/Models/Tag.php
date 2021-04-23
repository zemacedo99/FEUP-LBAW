<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps  = false;
    protected $table = 'tag';
    protected $fillable = ['value'];

    use HasFactory;

    public function items(){ return $this->belongsToMany('App\Models\Item');}
}
