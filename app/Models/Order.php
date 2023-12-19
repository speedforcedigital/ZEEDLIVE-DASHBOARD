<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'lot_id',
        'seller_id',
        'address_id',
        'sub_total',
        'shipping_fee',
        'total_amount',
        'payment_method',
        'status',
        'rating_id',
      ];

    public function customer(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function seller(){
        return $this->belongsTo('App\Models\User','seller_id');
    }
    public function rating(){
        return $this->belongsTo('App\Models\Rating','rating_id');
    }

    public function lot(){
        return $this->belongsTo('App\Models\Lot','lot_id');
    }

    public function address(){
        return $this->belongsTo('App\Models\Address','address_id');
    }

    public function scopeSold($query)
    {
        return $query->where('auction_status', 'Sold');
    }

    public function scopeIsScheduledLive($query)
    {
        return $query->where('is_scadual_live', 1);
    }

    public function commission()
    {
        return $this->hasOneThrough(CompanyWalletRecord::class, Lot::class, 'id', 'lot_id', 'lot_id', 'id');
    }
}
