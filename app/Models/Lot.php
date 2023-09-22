<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Auction;
use Carbon\Carbon;
use DateTime;
class Lot extends Model
{
    protected $table = 'lot';
    public $timestamps = true;

    protected $fillable = [
      'title',
      'description',
      'image',
      'price',
      'category_id',
      'brand_id',
      'model_id',
      'auction_id',
      'collection_id',
      'gender',
    ];

    protected $appends = [
        'IsFavourite',
        'TimeToStart',
        'TimeToEnd',
        'Brand',
        'Modal'
    ];

    public function reviews(){
        return $this->hasMany('App\Models\Rating');
    }

    public function getIsFavouriteAttribute()
    {
      $user = Auth()->user();
       if($user){
        $user_id = Auth::user()->id;
         $data = Favorite::where('lot_id',$this->id)->where('user_id',$user_id)->first();
         if($data){
           return "1";
         }
         else{
           return "0";
         }
       }else{
         return "0";
       }
    }

    public function getTimeToStartAttribute()
    {
      $auction = Auction::where('id',$this->auction_id)->first();
        $start_time = null;
              if($auction->start_time==null)
              {
                $start_time = $auction->start_time;
              }
              else
              {
                if($auction->start_time > Carbon::now())
                {
                  $date1 = $auction->start_time;
                  $diff = abs(strtotime(Carbon::now()) - strtotime($date1));
                  $years   = floor($diff / (365*60*60*24));
                  $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                  $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                  $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                  $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                  $s = $auction->start_time;
                  $dt = new DateTime($s);
                  $time = $dt->format('h:i:A');
                  if($days==0)
                  {
                    $end_time  = "Today ".$time;
                  }
                  elseif($days==1)
                  {
                    $start_time  = $days." day ".$time;
                  }
                  else
                  {
                    $start_time  = $days." days ".$time;
                  }
                }
                else
                {
                  $start_time=null;
                }
              }
              return $start_time;
    }
    public function getTimeToEndAttribute()
    {
      $auction = Auction::where('id',$this->auction_id)->first();

              if($auction->end_time==null)
              {
                $end_time = $auction->end_time;
              }
              else
              {
                if($auction->end_time > Carbon::now())
                {
                  $date1 = $auction->end_time;
                  $diff = abs(strtotime(Carbon::now()) - strtotime($date1));
                  $years   = floor($diff / (365*60*60*24));
                  $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                  $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                  $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                  $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                  $s = $auction->end_time;
                  $dt = new DateTime($s);
                  $time = $dt->format('h:i A');
                  if($days==0)
                  {
                    $end_time  = "Today ".$time;
                  }
                  elseif($days==1)
                  {
                    $end_time  = $days." day ".$time;
                  }
                  else
                  {
                    $end_time  = $days." days ".$time;
                  }

                }
                else
                {
                  $date1 = Carbon::now();
                  $diff = abs(strtotime($auction->end_time) - strtotime($date1));
                  $years   = floor($diff / (365*60*60*24));
                  $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                  $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                  $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                  $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                  $s = $auction->end_time;
                  $dt = new DateTime($s);
                  $time = $dt->format('h:i A');
                  if($days==0)
                  {
                    $end_time  = "Closed ".$time;
                  }
                  elseif($days==1)
                  {
                    $end_time  = "Closed ".$days." day ago";
                  }
                  else
                  {
                    $end_time  = "Closed " .$days." days ago";
                  }


                }
              }
              return $end_time;
    }

    public function getBrandAttribute()
    {
         $lot = DB::table('lot')->select('lot.brand_id')->where('lot.id',$this->id)->first();
         $Brand = DB::table('brands')->select('brands.name')->where('brands.id',$lot->brand_id)->first();
         return $Brand->name;
    }

    public function getModalAttribute()
    {
         $lot = DB::table('lot')->select('lot.model_id')->where('lot.id',$this->id)->first();
         $Model = DB::table('modals')->select('modals.name')->where('modals.id',$lot->model_id)->first();
         return $Model->name;
    }

    /**
     * Get the user that added the product.
     */
    public function auction(){
        return $this->belongsTo('App\Models\Auction');
    }
    public function collection(){
        return $this->belongsTo(MyCollection::class,'collection_id');
    }
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function bids()
    {
        return $this->hasMany('App\Models\BidDetails','lot_id','id');
    }

    /**
     * Get the number of unique bids for the lot.
     *
     * @return int
     */
    public function getNumberOfUniqueBidsAttribute()
    {
        return $this->bids->groupBy('user_id')->count();
    }
}
