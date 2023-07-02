<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'categories';
    public $timestamps = true;


    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'id', 'category_id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
    
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }


        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categoryFollower()
    {
        return $this->belongsToMany(Category::class, 'category_followers', 'category_id', 'user_id')->withTimestamps();
    }
}
