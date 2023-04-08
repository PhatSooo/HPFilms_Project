<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;
    protected $primaryKey = 'crew_id';
    protected $fillable = ['crew_id','crew_name','image','gender','position','nation'];

    public function movies(){
        return $this->belongsToMany(Movie::class,'movie_casts','crew_id','movie_id');
    }

    public function scopeActor($query)
    {
        return $query->where('position', 0);
    }

    public function scopeDirector($query)
    {
        return $query->where('position', '!=', 0);
    }
}
