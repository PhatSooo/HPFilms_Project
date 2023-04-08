<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory;
    protected $primaryKey = 'movie_id';
    protected $fillable = ['movie_id','title','overview','movie_status','image','date_release','runtime','trailer','production_country_id'];

    protected static function boot() {
        parent::boot();

        static::creating(function ($question) {
            $question->slug = Str::slug($question->title);
        });
    }

    public function genres(){
        return $this->belongsToMany(Genre::class,'movie_genres','movie_id','genre_id');
    }

    public function actors(){
        return $this->belongsToMany(Crew::class,'movie_casts','movie_id','crew_id');
    }

    public function crews(){
        return $this->belongsToMany(Crew::class,'movie_directors','movie_id','crew_id');
    }

    public function keywords(){
        return $this->belongsToMany(Keyword::class,'movie_keywords','movie_id','keyword_id');
    }
}
