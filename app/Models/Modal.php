<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Brand};
class Modal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','image','brand_id'
    ];
    protected $appends = [
        'brand'
    ];
    protected $table = 'modals';
    public $timestamps = true;

    public function getBrandAttribute()
    {
        $data = Brand::where('id',$this->brand_id)->first();
        if($data)
        {
          return $data->name;
        }
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modelFollower()
    {
        return $this->belongsToMany(Modal::class, 'model_followers', 'model_id', 'user_id')->withTimestamps();
    }
}
