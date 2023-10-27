<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    public function viewAll()
    {
        return view('admin.all-comments')->with('title', 'Danh sách comments');
    }

    public function viewEdit($id)
    {
        return view('admin.edit-admin', compact('id'))->with('title', 'Cập nhật admin');
    }

    public function viewAddAdmin()
    {
        return view('admin.add-admin')->with('title', 'Thêm admin');
    }
}
