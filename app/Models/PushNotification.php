<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable=['title','body','type',"end_stream"];
    protected $table = 'push_notifications';
    public $timestamps = true;
    use HasFactory;
}
