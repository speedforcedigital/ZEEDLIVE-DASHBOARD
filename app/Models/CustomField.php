<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $table = 'custom_fields';
   protected $primaryKey = 'custom_field_id';
    protected $fillable = [
        'custom_field_title',
        'category_id',
        'type',
        'values',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
