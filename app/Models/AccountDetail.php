<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
  public function getProfileImageAttribute($value)
    {
        if ($value) {
            return Storage::disk('s3')->url($value);
        }
        return null;
    }
    public function getCoverImageAttribute($value)
    {
        if ($value) {
            return Storage::disk('s3')->url($value);
        }
        return null;
    }
}
