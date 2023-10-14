<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function viewHome()
    {
        // $user = array();

        // if (Session::has('user_id'))
        //     $user = User::where('id', session('user_id'))->first();

        // return view('.user.home', compact('user'))->with('title', 'Trang chủ');
        return view('.user.home')->with('title', 'Trang chủ');
    }

    
}
