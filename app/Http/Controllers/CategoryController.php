<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function viewAll(){

        $all_category = Category::orderBy('id','DESC')->paginate(3);

        return view('admin.all-categories', compact('all_category'))->with('title', 'Danh sách danh mục');
    }

    public function viewAdd(){
        return view('admin.add-category')->with('title', 'Thêm danh mục');
    }

    public function viewEdit($id){
        $category = Category::where('id', $id)->firstOrFail();
        return view('admin.edit-category', compact('category'))->with('title', 'Cập nhật danh mục');
    }
}
