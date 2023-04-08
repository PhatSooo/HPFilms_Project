<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;
    protected $primaryKey = 'keyword_id';
    protected $fillable = ['keyword_id','keyword_name'];
}
