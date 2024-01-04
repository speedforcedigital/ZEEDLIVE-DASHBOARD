<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auction;

class MyCollection extends Model
{
    use HasFactory;

    protected $table = 'my_collections';
    protected $guarded = [];

    public function seller(){
        return $this->belongsTo(User::class,'offer_receiver_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function auction(){
        return $this->hasOne(Auction::class,'collection_id');
    }
    public function buyer(){
        return $this->belongsTo(User::class,'offer_sender_id');
    }
    public function offers()
    {
        return $this->hasMany(Offers::class,"collection_id", "id");
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function customFields()
    {
        return $this->hasMany(CustomField::class, 'category_id');
    }

    public function model()
    {
        return $this->belongsTo(Modal::class, 'model_id');
    }
}
