<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
  protected $table = 'card_details';
  public $timestamps = true;

  protected $fillable = [
      'holder_name',
      'exp_date',
      'card_number',
      'CVV',
      'user_id'
  ];



    public function user()
    {
      return $this->belongsTo('App\Models\User', 'user_id');
    }
}
