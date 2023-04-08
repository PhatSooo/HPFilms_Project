<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Favorite extends Model
{
    use HasFactory;
    public $table = "user_favorites";
    protected $fillable = ['movie_id','user_id'];
}
