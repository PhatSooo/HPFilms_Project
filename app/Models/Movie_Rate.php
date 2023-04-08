<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie_Rate extends Model
{
    use HasFactory;
    public $table = "movie_rates";
    protected $fillable = ['movie_id','user_id','stars'];
}
