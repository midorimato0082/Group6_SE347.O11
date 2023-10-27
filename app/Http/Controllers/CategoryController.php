<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function viewAll(){
        return view('admin.all-categories')->with('title', 'Danh sách danh mục');
    }

    public function viewAdd(){
        return view('admin.add-category')->with('title', 'Thêm danh mục');
    }

    public function viewEdit($id){
        $category = Category::where('id', $id)->firstOrFail();
        return view('admin.edit-category', compact('category'))->with('title', 'Cập nhật danh mục');
    }
}
