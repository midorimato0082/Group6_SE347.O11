<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Các function hiển thị view
    public function viewAll()
    {
        return view('admin.all-users')->with('title', 'Danh sách user');
    }

    public function viewEdit($id)
    {
        return view('admin.edit-admin', compact('id'))->with('title', 'Cập nhật admin');
    }

    public function viewAddAdmin()
    {
        return view('admin.add-admin')->with('title', 'Thêm admin');
    }

    public function viewProfile()
    {
        return view('admin.profile-admin')->with('title', 'Hồ sơ');
    }
}
