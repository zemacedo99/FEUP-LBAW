<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps  = false;
    protected $fillable = ['email', 'password'];

    use HasFactory;

}
