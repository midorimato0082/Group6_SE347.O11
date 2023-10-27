<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Location;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    // Các function hiển thị view
    public function viewAll()
    {
        return view('admin.all-reviews')->with('title', 'Danh sách bài viết');
    }

    public function viewEdit($id)
    {
        $review = Review::where('id', $id)->firstOrFail();
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.edit-review', compact('review', 'categories', 'locations'))->with('title', 'Cập nhật bài viết');
    }

    public function viewAdd()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.add-review', compact('categories', 'locations'))->with('title', 'Thêm bài viết');
    }

    // Các function thao tác với database
    public function update($id, Request $request)
    {
        $filename = '';
        if($request->file != ''){
            $path = public_path().'/images/reviews/';

            //upload new file
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);
        }

        $review = Review::where('id', $id)->firstOrFail();

        $review->update(array_merge($request->input(), [
            'images' => $filename,
            'slug' => Str::slug($review->title, '-'),
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
            $path = public_path().'/images/reviews/';

            //upload new file
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);
        }

        $review = Review::create(array_merge($request->input(), [
            'admin_id' => session('user.id'),
            'slug' => Str::slug($request->title, '-'),
            'images' => $filename,
        ]));
        $review->save();

        return redirect('all-review');
    }
}
