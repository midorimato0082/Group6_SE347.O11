<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $numberUser = User::count();
        $numberPost = count(Post::all());
        $numberComment = Comment::count();
        $numberLike = PostLike::count();

        $today = Carbon::today();
        $numberNewUser = User::whereDate('created_at', $today)->count();
        $numberNewPost = count(Post::whereDate('created_at', $today)->get());
        $numberNewComment = Comment::whereDate('created_at', $today)->count();
        $numberNewLike = PostLike::whereDate('created_at', $today)->count();

        $posts = Post::where('is_active', true)->count()->orderBy('created_at', 'DESC')->take(10)->get();
        $comments = Comment::where('is_active', true)->orderBy('created_at', 'DESC')->take(10)->get();
        
        return view('admin.dashboard', compact('numberUser', 'numberPost', 'numberComment', 'numberLike', 'numberNewUser', 'numberNewPost', 'numberNewComment', 'numberNewLike', 'posts', 'comments'))->with('title', 'Dashboard');
    }
}
