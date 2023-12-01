<?php

namespace App\Http\Controllers;

use App\Models\AccountDetail;
use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function view($id)
    {
        $lot = Lot::where("id", $id)->with("auction")->first();
        $lot->image = Storage::disk('do')->url($lot->image);
//        dd($lot);
        $lot->video = Storage::disk('do')->url($lot->video);
        $lot->auction->user->image = AccountDetail::where('user_id', $lot->auction->user->id)->first()->profile_image;
//        dd($lot->auction->user->image);
        $lot->gallery_images = DB::table('product_galleries')->where('product_id', $id)->get();
        foreach ($lot->gallery_images as $key => $value) {
            $lot->gallery_images[$key]->image = Storage::disk('do')->url($value->image);
        }
        return view("products.show",compact('lot'));
    }
}
