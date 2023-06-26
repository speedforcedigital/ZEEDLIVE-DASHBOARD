<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','is_seller_verified','seller_type'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
