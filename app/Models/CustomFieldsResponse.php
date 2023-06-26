<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldsResponse extends Model
{
    protected $table = 'custom_fields_response';
    public $timestamps = false;

    protected $fillable = [
      'id',
      'custom_field_id',
      'response',
      'collection_id',
    ];
}
