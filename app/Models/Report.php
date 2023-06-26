<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    
    protected $fillable = [
        'comment','user_id','reporting_user_id'
    ];
    use HasFactory;

}
