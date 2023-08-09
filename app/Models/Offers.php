<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Offers extends Model
{

    protected $table = 'offers';
    public $timestamps = true;
     protected $primaryKey = 'offer_id';
            protected $dates = ['time_to_end_offer','start_time'];

    protected $fillable = [
        'offer_id ','amount', 'duration', 'offer_sender_id','time_to_made_offer','duration','time_to_end_offer','collection_id','offer_receiver_id','is_accepted','modrator_status'
    ];

    protected $appends = [
        'CreatedTime',
    ];

    protected $hidden = [
        'updated_at'
    ];

public function user()
{
        return $this->belongsTo('App\Models\User','offer_sender_id','id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'offer_receiver_id', 'id');
    }

    public function collection()
    {
        return $this->belongsTo('App\Models\MyCollection', 'collection_id', 'id');
    }

    public function getCreatedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getDurationAttribute()
    {
        return $this->time_to_end_offer->diffForHumans();
    }
}
