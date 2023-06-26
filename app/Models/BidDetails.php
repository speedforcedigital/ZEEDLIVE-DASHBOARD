<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\PendingAuction;

class BidDetails extends Model
{

    protected $table = 'bid_details';
    public $timestamps = true;

    protected $fillable = [
        'user_id','lot_id', 'amount', 'type','is_accepted'
    ];

    protected $appends = [
        'CreatedTime',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function lot()
    {
        return $this->belongsTo('App\Models\Lot','lot_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function auction()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }


}
