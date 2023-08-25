<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalField extends Model
{
    use HasFactory;
       protected $primaryKey = 'global_field_id';
    protected $table = "global_fields";

      protected $fillable = [
        'global_field',
        'values',
    ];
}
