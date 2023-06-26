<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreezeModel extends Model
{
    use HasFactory;
    protected $table = "wallet_freez_amount";
    protected $primaryKey = "freez_id";



}
