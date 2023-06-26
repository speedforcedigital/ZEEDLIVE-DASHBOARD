<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDetail extends Model
{
  protected $table = 'account_detail';
  public $timestamps = true;
  protected $hidden = [
      'created_at', 'updated_at','id','user_id',
  ];
  protected $fillable = [
      'user_id', 'profile_image', 'cover_image','description','tagline','type'
  ];
}
