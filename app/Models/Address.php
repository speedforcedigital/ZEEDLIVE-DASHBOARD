<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    public $timestamps = true;

    protected $fillable = [
      'user_id',
      'address',
      'city',
      'zip_code',
      'country',
      'is_default',
      'longitude',
      'latitude',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
