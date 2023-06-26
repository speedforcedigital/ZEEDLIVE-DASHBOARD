<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
     
    protected $fillable = [
        'comment','user_id','time_duration'
    ];
    use HasFactory;
}
