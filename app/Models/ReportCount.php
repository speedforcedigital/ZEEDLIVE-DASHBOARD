<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCount extends Model
{
    protected $fillable = [
        'reportcount','user_id'
    ];
    use HasFactory;
}
