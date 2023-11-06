<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuPageController extends Controller
{
    public function viewCategoryPage($slug) {
        $category = Category::where('slug', $slug)->first();
        
        return view('.user.category-page')->with('title', $category->name);
    }
}
