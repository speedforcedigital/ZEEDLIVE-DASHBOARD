<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UserController extends Controller
{
    public function index()
    {
        $users = Users::simplePaginate(10);
        $users_count = Users::all()->count();
        return view('pages/users/users', compact('users', 'users_count'));
    }
    
}
