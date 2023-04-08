<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie_Keyword extends Model
{
    use HasFactory;
    public $table = "movie_keywords";
    protected $fillable = ['movie_id','keyword_id'];
}
