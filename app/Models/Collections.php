<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Collections extends Model
{
    protected $table = 'my_collections';
    public $timestamps = true;

    public function getImageAttribute($value)
    {
        return Storage::disk('do')->url($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
