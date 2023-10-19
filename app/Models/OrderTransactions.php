<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransactions extends Model
{
  protected $table = 'order_transactions';
  public $timestamps = true;

  protected $fillable = [
      'user_id',
      'order_id',
      'amount',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    public function scopeSold($query)
    {
        return $query->where('auction_status', 'Sold');
    }

    public function scopeIsScheduledLive($query)
    {
        return $query->where('is_scadual_live', 1);
    }
}
