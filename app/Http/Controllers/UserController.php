<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Các function hiển thị view
    public function viewAll()
    {
        $all_user = User::orderBy('id','DESC')->paginate(3);
        
        return view('.admin.all_user', compact('all_user'))->with('title', 'Danh sách user');
    }

    public function viewEdit()
    {
        return view('.admin.edit_user')->with('title', 'Cập nhật admin');
    }

    public function viewAddAdmin()
    {
        return view('.admin.add_admin')->with('title', 'Thêm admin');
    }

    // Các function thao tác với database
    public function update()
    {
        
    }

    public function delete()
    {
        
    }

    public function saveAdmin()
    {
        
    }
}
