<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  protected $table = 'transactions';
  public $timestamps = true;

  protected $fillable = [
      'user_id', 'amount', 'currency','token', 'transaction_time', 'transaction_id', 'cart_id', 'card_scheme', 'card_type', 'payment_description',
  ];

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }
}
