<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyWalletRecord extends Model
{
    use HasFactory;
    protected $table = 'company_wallet_record';


    public function buyer()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function lot()
    {
        return $this->belongsTo('App\Models\Lot','lot_id','id');
    }
    public function seller()
    {
        return $this->belongsTo('App\Models\User','seller_id','id');
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


