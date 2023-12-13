<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasFactory;

    protected $table = 'refunds';

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
