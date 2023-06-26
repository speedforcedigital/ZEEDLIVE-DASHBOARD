<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
  protected $table = 'follower';
  public $timestamps = true;

   public function isFollowed($authUserId, $auctionUserId)
    {
        $follower = $this->where('leader_id', $auctionUserId)
                         ->where('follower_id', $authUserId)
                         ->first();
        return $follower ? true : false;
    }
}
