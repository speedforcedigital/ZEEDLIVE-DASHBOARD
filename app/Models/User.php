<?php

namespace App\Models;
use DB;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ZeedliveAccountCreated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'device_token', 'password','role_id','gender','mobile','role','status','rank','test','is_temp_password','is_deleted','is_admin','seller_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'device_token'
    ];
    protected $appends = [
        'accountDetail','role', 'follower', 'following', 'collection',
    ];
    // public function getAuctualRateAttribute()
    // {
    //   $getRanking = DB::table('rating')
    // ->selectRaw('seller_id, name, SUM(rating) as "totalRate", COUNT(seller_id) as "totalCount" ')
    // ->join('users', 'users.id', '=', 'rating.seller_id')
    // ->groupBy('seller_id', 'name') // Include 'name' in the GROUP BY clause
    // ->where('seller_id', $this->id)
    // ->get();

    //         dd($getRanking);
    //     if (!$getRanking->isEmpty()) {
    //         $AuctualRate =  sprintf("%.2f", $getRanking[0]->totalRate / $getRanking[0]->totalCount);
    //         $data = ($AuctualRate < 1000 ? $AuctualRate : thousand_format($AuctualRate));
    //     } else {
    //         $data = '0.00';
    //     }
    //     return $data;
    // }

    public function getAccountDetailAttribute()
    {
       $AccountDetail = AccountDetail::where('user_id',$this->id)->first();
       return $AccountDetail;
    }

    public function getFollowerAttribute()
    {
       $followers = Followers::where('leader_id',$this->id)->count();
       return $followers;
    }

    public function getFollowingAttribute()
    {
       $following = Followers::where('follower_id',$this->id)->count();
       return $following;
    }

    public function getCollectionAttribute()
    {
       $Collections = Collections::where('user_id',$this->id)->count();
       return $Collections;
    }

    public function getRoleAttribute()
    {
       $roles=Role::where('id',$this->role_id)->first();
       return $roles;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function AdminAccountCreateNotification($password ,$email)
    {
        $this->notify(new ZeedliveAccountCreated($password,$email));
    }

    public function SellerVerification()
    {
        return $this->hasOne(SellerVerification::class);
    }

    public function Role()
    {
      return $this->belongsTo('App\Models\Role', 'role_id');
    }

    /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follower', 'leader_id', 'follower_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follower', 'follower_id', 'leader_id')->withTimestamps();
    }

    public function products()
     {
         return $this->hasMany('App\Models\Lot');
     }

     public function cards()
      {
          return $this->hasMany('App\Models\CardDetail','user_id','id');
      }

      public function transactions()
       {
           return $this->hasMany('App\Models\Transaction','user_id','id');
       }

     /**
     * Get the reviews the user has made.
     */
     public function rating()
     {
        return $this->hasMany('App\Models\Rating');
     }

     /**
    * @return HasOne
    * @description get the detail associated with the post
    */
     public function wallet()
     {
         return $this->hasOne('App\Models\Wallet', 'user_id', 'id');
     }

}
