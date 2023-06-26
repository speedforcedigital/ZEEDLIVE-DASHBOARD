<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleLiveStream extends Model
{
    use HasFactory;
    protected $table = "scadual_live_stream";
      protected $primaryKey = 'stream_id';

}
