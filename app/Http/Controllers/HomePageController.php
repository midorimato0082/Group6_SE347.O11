<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function viewHomePage() {

        return view('.user.home-page')->with('title', 'Trang chủ');
    }

    public function viewProfile() {

        return view('.user.profile')->with('title', 'Hồ sơ');
    }
}
