<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    protected $table = 'rating';
    public $timestamps = true;

    protected $fillable = [
      'user_id',
      'seller_id',
      'comment',
      'rating',
    ];

    public function seller()
    {
        return $this->belongsTo('App\Models\User','seller_id','id');
    }

    /**
     * Get the user that made the review.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
