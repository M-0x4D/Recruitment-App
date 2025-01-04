<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    public $timestamps = false;  // Disable timestamps
    protected $fillable = ['user_id','expires_at', 'path', 'application_id'];
}
