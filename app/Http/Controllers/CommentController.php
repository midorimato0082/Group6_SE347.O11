<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function viewAll()
    {
        return view('admin.all-comments')->with('title', 'Danh sách bình luận');
    }
}
