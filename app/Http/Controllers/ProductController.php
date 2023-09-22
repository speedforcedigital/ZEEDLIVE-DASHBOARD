<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function view($id)
    {
        $lot = Lot::where("id", $id)->with("auction")->first();
        return view("products.show",compact('lot'));
    }
}
