<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    protected $table = 'favorite';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'lot_id',
        'collection_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function lot(){
        return $this->belongsTo('App\Models\Lot','lot_id','id');
    }

}
