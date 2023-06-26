<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideos extends Model
{
    protected $table = 'product_videos';
    public $timestamps = false;

    protected $fillable = [
      'product_id',
      'video',
    ];
}
