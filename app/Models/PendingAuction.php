<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingAuction extends Model
{
    protected $table = 'pending_auctions';
    public $timestamps = true;

    protected $fillable = [
        'lot_id',
        'buyer_id',
        'bid_id',
        'time',
        'status',
      ];
    protected $appends = [
      'TimeLeft',
    ];

      public function lot()
      {
          return $this->belongsTo('App\Models\Lot','lot_id','id');
      }
      public function user()
      {
          return $this->belongsTo('App\Models\User','buyer_id','id');
      }

      public function bid()
      {
          return $this->belongsTo('App\Models\BidDetails','bid_id','id');
      }

      public function getTimeLeftAttribute()
      {
        return $this->created_at->diffForHumans();
      }
}
