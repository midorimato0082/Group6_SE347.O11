<?php

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    public function viewAll(){
        return view('admin.all-categories')->with('title', 'Danh sách danh mục');
    }

    public function viewAdd(){
        return view('admin.add-category')->with('title', 'Thêm danh mục');
    }
}
