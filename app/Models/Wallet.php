<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'amount',
    ];
}
