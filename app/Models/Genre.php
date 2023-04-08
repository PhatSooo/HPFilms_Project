<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $primaryKey = 'genre_id';
    protected $fillable = ['genre_id', 'genre_name'];

    public function movies(){
        return $this->belongsToMany(Movie::class,'movie_genres','genre_id','movie_id');
    }
}
