<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Category};
use App\Models\Modal;

class Brand extends Model
{
  use HasFactory;

    protected $fillable = [
        'name','image','category_id'
    ];

    protected $appends = [
        'category'
    ];
    protected $table = 'brands';
    public $timestamps = true;

    public function getCategoryAttribute()
    {
        $data = Category::where('id',$this->category_id)->first();
        if($data)
        {
          return $data->name;
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function modal()
    {
        return $this->belongsTo('App\Models\Modal', 'id', 'brand_id');
    }

    public function models()
    {
        return $this->hasMany(Modal::class, 'brand_id');
    }    

    /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function brandFollower()
  {
      return $this->belongsToMany(Brand::class, 'brand_followers', 'brand_id', 'user_id')->withTimestamps();
  }

    
}
