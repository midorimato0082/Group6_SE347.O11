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
        return view('admin.all-comments')->with('title', 'Danh sách bình luận');
    }
}
