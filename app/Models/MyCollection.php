<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auction;

class MyCollection extends Model
{
    use HasFactory;

    protected $table = 'my_collections';

    public function seller(){
        return $this->belongsTo(User::class,'offer_receiver_id');
    }
    public function auction(){
        return $this->hasOne(Auction::class,'collection_id');
    }
    public function buyer(){
        return $this->belongsTo(User::class,'offer_sender_id');
    }
}
