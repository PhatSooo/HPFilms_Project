<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify_Email extends Model
{
    public $timestamps = false;
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $table = "verify_emails";
}
