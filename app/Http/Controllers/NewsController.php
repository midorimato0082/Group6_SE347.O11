<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Location;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // Các function hiển thị view
    public function viewAll()
    {
        return view('admin.all_news')->with('title', 'Danh sách bài viết');
    }

    public function viewEdit($id)
    {
        $news = News::where('id', $id)->firstOrFail();
        $categories = Category::all();
        return view('admin.edit_news', compact('news', 'categories'))->with('title', 'Cập nhật bài viết');
    }

    public function viewAdd()
    {
        return view('admin.add_news')->with('title', 'Thêm bài viết');
    }

    // Các function thao tác với database
    public function update($id, Request $request)
    {
        $filename = '';
        if($request->file != ''){
            $path = public_path().'/images/news/';

            //upload new file
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);
        }

        $news = News::where('id', $id)->firstOrFail();

        $news->update(array_merge($request->input(), [
            'images' => $filename,
            'slug' => Str::slug($news->title, '-'),
        ]));

        return redirect()->back();
    }

    public function delete()
    {

    }

    public function save(Request $request)
    {
        $filename = '';
        if($request->file != ''){
            $path = public_path().'/images/news/';

            //upload new file
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);
        }

        $news = News::create(array_merge($request->input(), [
            'admin_id' => session('user.id'),
            'slug' => Str::slug($request->title, '-'),
            'images' => $filename,
        ]));
        $news->save();

        return redirect('all-news');
    }
}
