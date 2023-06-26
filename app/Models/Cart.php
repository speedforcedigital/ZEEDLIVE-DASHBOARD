<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'lot_id',
        'status',
        'experied_time',
        'offer_id'
    ];

    protected $table = 'carts';
    public $timestamps = true;

    protected $appends = [
      'createdTimeAgo',
  ];

    public function lot()
    {
      return $this->belongsTo('App\Models\Lot', 'lot_id');
    }

    public function getCreatedTimeAgoAttribute()
    {
        if( $this->created_at){
            $date = $this->created_at->format('d-m-Y');
            return $date;
        }else {
            return null;
        }
    }
}
